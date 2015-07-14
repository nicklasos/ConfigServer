<?php
use Nicklasos\ConfigServer\ConfigServer;
use Nicklasos\ConfigServer\Storage\MongoStorage;

class MongoStorageTest extends PHPUnit_Framework_TestCase
{
    use BaseOperations;

    /**
     * @var Nicklasos\ConfigServer\ConfigServer
     */
    private $config;

    /**
     * @var \Nicklasos\ConfigServer\Storage\MongoStorage
     */
    private $mongoStorage;

    protected function setUp()
    {
        $this->mongoStorage = new MongoStorage('ConfigServer_test', 'config', 'localhost');
        $this->config = new ConfigServer($this->mongoStorage);
    }

    protected function tearDown()
    {
        $this->mongoStorage->collection()->drop();
    }
}
