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
}