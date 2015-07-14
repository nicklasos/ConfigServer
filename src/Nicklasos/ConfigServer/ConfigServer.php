<?php
namespace Nicklasos\ConfigServer;

use Nicklasos\ConfigServer\Cache\Cache;
use Nicklasos\ConfigServer\Cache\NullableMemcache;
use Nicklasos\ConfigServer\Storage\MongoStorage;
use Nicklasos\ConfigServer\Storage\StorageInterface;

class ConfigServer
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var Cache
     */
    private $cache;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->cache = new Cache(new NullableMemcache());
    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return ConfigServer
     */
    public static function createDefault()
    {
        // TODO: you can change it on prod
        return new ConfigServer(new MongoStorage(
            'ConfigServer',
            'config',
            'localhost'
        ));
    }

    public function set($key, $value)
    {
        $this->cache->set($key, $value);
        $this->storage->set($key, $value);
    }

    public function get($key)
    {
        if ($key = $this->cache->get($key)) {
            return $key;
        }

        $value = $this->storage->get($key);
        $this->cache->set($key, $value);

        return $value;
    }

    public function getAll()
    {
        if ($data = $this->cache->getAll()) {
            return $data;
        }

        $data = $this->storage->getAll();
        $this->cache->setAll($data);

        return $data;
    }

    public function drop($key)
    {
        $this->cache->drop($key);
        $this->storage->drop($key);
    }

    public function dropCache()
    {
        $this->cache->dropAll();
    }
}
