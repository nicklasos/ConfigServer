<?php
namespace Nicklasos\ConfigServer\Cache;

class Cache
{
    /**
     * @var \Memcache
     */
    private $cache;

    /**
     * @var int
     */
    private $timeout;

    const PREFIX = 'ConfigServer:';
    const INTERNAL_PREFIX = 'ConfigServer:internal:';

    public function __construct(\Memcache $cacheInstance, $timeout = 600)
    {
        $this->cache = $cacheInstance;
        $this->timeout = $timeout;
    }

    public function set($key, $value)
    {
        $this->saveKey($key);
        $this->cache->set(self::PREFIX . $key, $value, MEMCACHE_COMPRESSED, $this->timeout);
    }

    public function get($key)
    {
        return $this->cache->get(self::PREFIX . $key);
    }

    public function getAll()
    {
        return $this->cache->get(self::INTERNAL_PREFIX . 'all-data');
    }

    public function setAll($values)
    {
        $this->cache->set(self::INTERNAL_PREFIX . 'all-data', $values);
    }

    public function drop($key)
    {
        $this->dropKey($key);
        $this->cache->delete(self::PREFIX . $key);
    }

    public function dropAll()
    {
        foreach ($this->cache->get(self::INTERNAL_PREFIX . 'all-keys') as $key) {
            $this->drop($key);
        }
        
        $this->cache->delete(self::INTERNAL_PREFIX . 'all-data');
    }

    private function dropKey($delete)
    {
        $this->updateAllKeys(function ($keys) use ($delete) {
            if(($key = array_search($delete, $keys)) !== false) {
                unset($keys[$key]);
            }

            return $keys;
        });
    }

    private function saveKey($key)
    {
        $this->updateAllKeys(function ($keys) use ($key) {
            if (!is_array($keys)) {
                $keys = [];
            }

            $keys[] = $key;

            return $keys;
        });
    }

    private function updateAllKeys(callable $callback)
    {
        $keys = $this->cache->get(self::INTERNAL_PREFIX . 'all-keys');

        $keys = $callback($keys);

        $this->cache->set(self::INTERNAL_PREFIX . 'all-keys', array_unique($keys));
    }
}
