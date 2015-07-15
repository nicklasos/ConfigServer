<?php

use Nicklasos\ConfigServer\Cache\NullableMemcache;
use Nicklasos\ConfigServer\ConfigServer;

class ConfigServerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDefault()
    {
        $this->assertInstanceOf(ConfigServer::class, ConfigServer::createDefault());
    }
}
