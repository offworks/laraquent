<?php
namespace Laraquent\Support\Exedra;

class Provider implements \Exedra\Provider\ProviderInterface
{
	public function register(\Exedra\Application $app)
	{
		$app->wizard->add(\Laraquent\Support\Exedra\Wizard::class);

		if(!$app->config->has('db'))
			throw new \Exception('db. configuration is required.');

		$config = $app->config;

		$capsule = new \Illuminate\Database\Capsule\Manager;

		$capsule->addConnection(array(
			'driver' => $config->get('db.driver', 'mysql'),
			'host' => $config->get('db.host', 'localhost'),
			'database' => $config->get('db.name'),
			'username' => $config->get('db.user'),
			'password' => $config->get('db.pass'),
			'charset' => $config->get('db.charset', 'utf8'),
			'collation' => $config->get('db.collation', 'utf8_unicode_ci')
			));

		$capsule->setAsGlobal();

		$capsule->bootEloquent();

		// register eloquent
		$app->eloquent = $capsule;
	}
}


