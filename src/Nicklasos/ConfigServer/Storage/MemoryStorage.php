<?php
namespace Nicklasos\ConfigServer\Storage;

class MemoryStorage implements StorageInterface
{
    private $values;

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    public function getAll()
    {
        return $this->values;
    }

    public function drop($key)
    {
        unset($this->values[$key]);
    }
}
