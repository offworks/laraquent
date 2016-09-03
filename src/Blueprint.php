<?php
namespace Laraquent;

class Blueprint extends \Illuminate\Database\Schema\Blueprint
{
	protected $builder;

	public function __construct($table, \Closure $callback = null, Schema $builder)
	{
		$this->builder = $builder;

		parent::__construct($table, $callback);
	}

	/**
	 * Add column only if there isn't one.
	 * So it will not throw if there already exists.
	 */
	public function addColumn($type, $column, array $parameters = array())
	{
		// check against existing
		if(!$this->builder->hasColumn($this->table, $column))
			return parent::addColumn($type, $column, $parameters);

		// else probably compare and do some alteration
	}

	/**
     * Add a "deleted at" timestamp for the table.
     *
     * @return \Illuminate\Support\Fluent
     */
	public function softDeletes()
	{
		$timestamp = $this->timestamp('deleted_at');

		if(is_object($timestamp))
			$timestamp->nullable();
	}

	/**
	 * Adds the `remember_token` column to the table.
	 *
	 * @return \Illuminate\Support\Fluent
	 */
	public function rememberToken()
	{
		$object = $this->string('remember_token', 100);

		if(is_object($object))
			$object->nullable();
	}

	/**
	 * Add nullable creation and update timestamps to the table.
	 *
	 * @return void
	 */
	public function nullableTimestamps()
	{
		$timestamp = $this->timestamp('created_at');

		if(is_object($timestamp))
			$timestamp->nullable();

		$timestamp = $this->timestamp('updated_at');

		if(is_object($timestamp))
			$timestamp->nullable();
	}
}