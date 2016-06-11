<?php
namespace Laraquent\Support\Exedra;

class Wizard extends \Exedra\Wizard\Wizardry
{
	protected static $namespace = 'model';

	/**
	 * Migrate eloquent schema
	 * Use db.schema_path config if configured
	 * @description Migrate eloquent schema
	 */
	public function executeMigrate()
	{
		$this->app->eloquent->getConnection()->useDefaultSchemaGrammar();

		$file = $this->app->path->file($this->app->config->get('db.schema_path', 'schema/schema.php'));

		if(!$file->isExists())
			throw new \Exception('['.$file.'] does not exists.');

		$file->load(array(
			'schema' => new \Nova\Laraquent\Schema($this->app->eloquent->getConnection())
			));
	}
}