<?php
namespace Nicklasos\ConfigServer\Cache;

class NullableMemcache extends \Memcache
{
    private $values;

    public function set($key, $var, $flag = null, $expire = 0)
    {
        $this->values[$key] = $var;
    }

    public function get($key, $flags = null)
    {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    public function delete($key, $timeout = 0)
    {
        unset($this->values[$key]);
    }

    public function flush() {}
}
