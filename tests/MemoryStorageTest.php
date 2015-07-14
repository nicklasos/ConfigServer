<?php
use Nicklasos\ConfigServer\ConfigServer;
use Nicklasos\ConfigServer\Storage\MemoryStorage;

class MemoryStorageTest extends PHPUnit_Framework_TestCase
{
    use BaseOperations;

    /**
     * @var Nicklasos\ConfigServer\ConfigServer
     */
    private $config;

    protected function setUp()
    {
        $this->config = new ConfigServer(new MemoryStorage());
    }
}
