<?php
use Nicklasos\ConfigServer\Cache\Cache;
use Nicklasos\ConfigServer\Cache\NullableMemcache;
use Nicklasos\ConfigServer\ConfigServer;
use Nicklasos\ConfigServer\Storage\MongoStorage;

class CacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Cache
     */
    private $cache;

    public function setUp()
    {
        $this->cache = new Cache(new NullableMemcache());
    }

    public function testGetSet()
    {
        $this->cache->set('key', 'value');

        $this->assertEquals('value', $this->cache->get('key'));
    }

    public function testSetAll()
    {
        $this->assertNull($this->cache->getAll());

        $data = ['foo', 'bar', 'baz'];

        $this->cache->setAll($data);

        $this->assertEquals($data, $this->cache->getAll());
    }

    public function testDrop()
    {
        $this->cache->set('key:1', 'value:1');
        $this->cache->set('key:2', 'value:2');

        $this->cache->drop('key:1');

        $this->assertNull($this->cache->get('key:1'));

        $this->assertEquals('value:2', $this->cache->get('key:2'));
    }

    public function testDropAllCache()
    {
        $this->cache->set('key:1', 'value:1');
        $this->cache->set('key:2', 'value:2');

        $this->cache->dropAll();

        $this->assertNull($this->cache->get('key:1'));
        $this->assertNull($this->cache->get('key:2'));
    }

    public function testCache()
    {
        $storage = new MongoStorage('ConfigServer_test', 'config', 'localhost');
        $config = new ConfigServer($storage);

        $config->setCache(new Cache(new NullableMemcache()));

        $config->set('key', 'value');
        $config->set('key:2', 'value:2');

        $this->assertEquals('value', $config->get('key'));

        $storage->collection()->drop();

        $this->assertEquals('value', $config->get('key'));
        $this->assertEquals('value:2', $config->get('key:2'));
    }
}
