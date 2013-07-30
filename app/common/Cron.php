<?php

class Cron
{
    /**
     * @param bool If it is true, forcing to run the cron without knowing if reached pre defined cron threshold time.
     * @return bool
     */
    public static function run($force = FALSE)
    {
        $now = time();
        $lastTime = Variable::get('system_cron_last', 0);
        Log::info('Checking for cron job');
        if ( $force 
            || $lastTime == 0
            || $now - $lastTime > Variable::get('system_cron_threshold', 3600)) {
            @ignore_user_abort(TRUE);
            if (Lock::acquire('cron', 240.0)) {
                Log::info('Starting cron job');

                // Notice: To avoid php execution timeout, all callback functions listen to this event should not
                // include time consuming procedures something like http/socket connections etc..
                Event::fire('system.cron');

                Variable::set('system_cron_last', $now);
                Lock::release('cron');
                Log::info('Cron job finished');
                return TRUE;
            } else {
                Log::warning('Attempting to re-run cron while it is already running.');
            }
        }
        return FALSE;
    }
}
