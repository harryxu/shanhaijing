<?php namespace Shanhaijing\Lock;

/**
 * All codes in this class are borrowed (actually copied) from Drupal 7 lock mechanisms.
 * @see https://api.drupal.org/api/drupal/includes%21lock.inc/7
 */

class DBStoreLock
{
    protected $db;
    protected $locks;
    protected $lock_id;
    protected $table = 'semaphore';

    public function __construct($db)
    {
        $this->db = $db;
        $locks = array();
        $this->lock_id = uniqid(mt_rand(), TRUE);
    }

    public function acquire($name, $timeout = 30.0)
    {
        // Insure that the timeout is at least 1 ms.
        $timeout = max($timeout, 0.001);
        $expire = microtime(TRUE) + $timeout;

        if (isset($this->locks[$name])) {
            $success = (bool)$this->db->table($this->table)
                ->where('name', $name)
                ->where('value', $this->lock_id)
                ->update(array('expire' => $expire));
            if (!$success) {
                // The lock was broken.
                unset($this->locks[$name]);
            }
            return $success;
        } else {
            // Optimistically try to acquire the lock, then retry once if it fails.
            // The first time through the loop cannot be a retry.
            $retry = FALSE;
            // We always want to do this code at least once.
            do {
                try {
                    $this->db->table($this->table)->insert(array(
                        'name' => $name, 
                        'value' => $this->lock_id, 
                        'expire' => $expire, 
                    ));
                    // We track all acquired locks in the global variable.
                    $this->locks[$name] = TRUE;
                    // We never need to try again.
                    $retry = FALSE;
                } catch (\Exception $e) {
                    // Suppress the error. If this is our first pass through the loop,
                    // then $retry is FALSE. In this case, the insert must have failed
                    // meaning some other request acquired the lock but did not release it.
                    // We decide whether to retry by checking lock_may_be_available()
                    // Since this will break the lock in case it is expired.
                    $retry = $retry ? FALSE : $this->may_be_available($name);
                }
            } while ($retry);
        }
        return isset($this->locks[$name]);
    }

    public function may_be_available($name)
    {
        $lock = $this->db->table($this->table)->where('name', $name)->first();
        if (!$lock) {
          return TRUE;
        }
        $expire = (float) $lock->expire;
        $now = microtime(TRUE);
        if ($now > $expire) {
            // We check two conditions to prevent a race condition where another
            // request acquired the lock and set a new expire time. We add a small
            // number to $expire to avoid errors with float to string conversion.
            return (bool)$this->db->table($this->table)
                ->where('name', $name)
                ->where('value', $lock->value)
                ->where('expire', '<=', 0.001 + $expire)
                ->delete();
        }
        return FALSE;
    }

    public function wait($name, $delay = 30)
    {
        // Pause the process for short periods between calling
        // lock_may_be_available(). This prevents hitting the database with constant
        // database queries while waiting, which could lead to performance issues.
        // However, if the wait period is too long, there is the potential for a
        // large number of processes to be blocked waiting for a lock, especially
        // if the item being rebuilt is commonly requested. To address both of these
        // concerns, begin waiting for 25ms, then add 25ms to the wait period each
        // time until it reaches 500ms. After this point polling will continue every
        // 500ms until $delay is reached.

        // $delay is passed in seconds, but we will be using usleep(), which takes
        // microseconds as a parameter. Multiply it by 1 million so that all
        // further numbers are equivalent.
        $delay = (int) $delay * 1000000;
        
        // Begin sleeping at 25ms.
        $sleep = 25000;
        while ($delay > 0) {
          // This function should only be called by a request that failed to get a
          // lock, so we sleep first to give the parallel request a chance to finish
          // and release the lock.
          usleep($sleep);
          // After each sleep, increase the value of $sleep until it reaches
          // 500ms, to reduce the potential for a lock stampede.
          $delay = $delay - $sleep;
          $sleep = min(500000, $sleep + 25000, $delay);
          if ($this->may_be_available($name)) {
            // No longer need to wait.
            return FALSE;
          }
        }
        // The caller must still wait longer to get the lock.
        return TRUE;
    }

    public function release($name)
    {
        unset($this->locks[$name]);
        $this->db->table($this->table)
            ->where('name', $name)
            ->where('value', $this->lock_id)
            ->delete();
    }

    public function release_all($lock_id = NULL)
    {
        $this->locks = array();
        if (empty($lock_id)) {
          $lock_id = $this->lock_id();
        }
        $this->db->table($this->table)
            ->where('value', $this->lock_id)
            ->delete();
    }
}
