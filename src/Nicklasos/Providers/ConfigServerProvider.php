<?php
namespace Nicklasos\Providers;

use Nicklasos\ConfigServer\Cache\Cache;
use Nicklasos\ConfigServer\ConfigServer;
use Nicklasos\ConfigServer\Storage\MongoStorage;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ConfigServerProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['config.server'] = $app->share(function () use ($app) {
            if ($app['debug']) {
                $config = new ConfigServer(new MongoStorage('ConfigServer', 'config', 'localhost'));
            } else {
                $config = ConfigServer::createDefault();
            }
            $config->setCache(new Cache($app['memcache']));

            return $config;
        });
    }

    public function boot(Application $app)
    {
    }
}
