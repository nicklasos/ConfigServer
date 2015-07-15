# Config node

  
[![Build Status](https://travis-ci.org/nicklasos/ConfigServer.svg?branch=master)](https://travis-ci.org/nicklasos/ConfigServer)

## Usages:
```php
// MongoDB storage
$storage = new MongoStorage(
    'ConfigServer', // db name
    'config', // collection
    'localhost' // host
));

// Memory storage
$storage = new MemoryStorage();

$config = new ConfigServer($storage);

$config->set('key', 'value');
echo $config->get('key');

$config->drop('key');

var_dump($config->getAll());


// Use cache

$memcache = new Memcache();
$memcache->connect('localhost', 11211);

$config->setCache(new ConfigServer\Cache\Cache($memcache, 300)); // 5 minutes

$config->dropCache();
```

## Custom storage
```php
class CustomStorage implements StorageInterface
{
    public function set($key, $value)
    {
    }

    public function get($key)
    {
    }

    public function getAll()
    {
    }

    public function drop($key)
    {
    }
}

```

## Silex provider
```php
$app->register(new ConfigServerProvider());
```
