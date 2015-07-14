<?php

/**
 * @method assertEquals
 * @method assertNull
 */
trait BaseOperations
{
    public function testSetGet()
    {
        $this->config->set('key', 'value');
        $result = $this->config->get('key');

        $this->assertEquals('value', $result);
    }

    public function testEmpty()
    {
        $this->assertNull($this->config->get('unknown'));
    }

    public function testGetAll()
    {
        $this->config->set('key.1', 'value.1');
        $this->config->set('key.2', 'value.2');

        $this->assertEquals(
            [
                'key.1' => 'value.1',
                'key.2' => 'value.2',
            ],
            $this->config->getAll()
        );
    }

    public function testDropKey()
    {
        $this->config->set('key', 'value');
        $this->config->drop('key');

        $this->assertNull($this->config->get('key'));
    }

    public function testArrayValue()
    {
        $array = [
            'key-1' => 'value-1',
            'key-2' => 'value-2',
        ];

        $this->config->set('key', $array);

        $this->assertEquals($array, $this->config->get('key'));
    }
}
