<?php

namespace Laraquent;

use Illuminate\Database\Capsule\Manager;

class Factory
{
    /**
     * Create eloquent Capsule Manager
     *
     * @param array $config
     * @return Manager
     * @throws \Exception
     */
    public static function create(array $config)
    {
        if (!isset($config['name']) || !isset($config['user']) || !isset($config['pass']))
            throw new \Exception('[name] and [user] and [pass] is required for Eloquent.');

        $capsule = new Manager;
        $capsule->addConnection(array(
            'driver' => isset($config['driver']) ? $config['driver'] : 'mysql',
            'host' => isset($config['host']) ? $config['host'] : 'localhost',
            'database' => $config['name'],
            'username' => $config['user'],
            'password' => $config['pass'],
            'charset' => isset($config['charset']) ? $config['charset'] : 'utf8',
            'collation' => isset($config['collation']) ? $config['collation'] : 'utf8_general_ci'
        ));

        return $capsule;
    }

    /**
     * Boot eloquent Capsule Manager
     *
     * @param array $config
     * @return Manager
     * @throws \Exception
     */
    public static function boot(array $config)
    {
        $capsule = static::create($config);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}