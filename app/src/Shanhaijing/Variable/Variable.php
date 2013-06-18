<?php namespace Shanhaijing\Variable;

class Variable
{
    protected $cache = array();

    protected $db;

    protected $table = 'variables';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Returns a persistent variable. 
     */
    public function get($name, $default = null)
    {
        if (!isset($this->cache[$name])) {
            $var = $this->db->table($this->table)->where('name', $name)->first();
            if ($var === null) {
                return $default;
            }
            else {
                $this->cache[$name] = $var->value;
            }
        }
        return $this->cache[$name];
    } 

    /**
     * Sets a persistent variable.
     */
    public function set($name, $value)
    {
        $var = $this->get($name);
        if ($var === null && $value === null) {
            return;
        }
        else if ($value === null) {
            $this->del($name);
        }
        else {
            if ($var === null) {
                $this->db->table($this->table)->insert(array(
                    'name' => $name, 'value' => $value,
                ));
            }
            else {
                $this->db->table($this->table)
                    ->where('name', $name)
                    ->update(array('value' => $value));
            }
        }

        $this->cache[$name] = $value;
    }

    /**
     * Unsets a persistent variable.
     */
    public function del($name)
    {
        $this->db->table($this->table)->where('name', $name)->delete();
        if (isset($this->cache[$name])) {
            unset($this->cache[$name]);
        }
    }

}
