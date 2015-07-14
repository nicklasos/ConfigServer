<?php
namespace Nicklasos\ConfigServer\Storage;

use MongoClient;

class MongoStorage implements StorageInterface
{
    private $db;
    private $collection;
    private $host;
    private $mongo;

    public function __construct($db, $collection, $host)
    {
        $this->db = $db;
        $this->collection = $collection;
        $this->host = $host;
    }

    public function set($key, $value)
    {
        $this->collection()->update(
            [
                'key' => $key,
            ],
            [
                'key' => $key,
                'value' => $value,
            ],
            [
                'upsert' => true,
            ]
        );
    }

    public function get($key)
    {
        $param = $this->collection()->findOne([
            'key' => $key,
        ]);

        if ($param && isset($param['value'])) {
            return $param['value'];
        }

        return null;
    }

    public function getAll()
    {
        $result = [];
        foreach ($this->collection()->find() as $doc) {
            $result[$doc['key']] = $doc['value'];
        }

        return $result;
    }

    public function drop($key)
    {
        $this->collection()->remove([
            'key' => $key,
        ]);
    }

    /**
     * @return \MongoCollection
     */
    public function collection()
    {
        if ($this->mongo === null) {
            $client = new MongoClient("mongodb://{$this->host}:27017");
            $this->mongo = $client->selectDB($this->db);
        }

        return $this->mongo->selectCollection($this->collection);
    }
}
