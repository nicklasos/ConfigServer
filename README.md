# Config node

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

$config->setCache(new ConfigServer\Cache\Cache($memcache));
```

## Silex provider
```php
$app->register(new ConfigServerProvider());
```
