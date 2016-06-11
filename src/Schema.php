<?php
namespace Laraquent;

class Schema extends \Illuminate\Database\Schema\Builder
{
	public function __construct(\Illuminate\Database\Connection $connection)
	{
		if(!$connection->getSchemaGrammar())
			$connection->useDefaultGrammar();
		
		parent::__construct($connection);
	}

	/**
	 * Create table if not exist.
	 * @param string table
	 * @param \Closure $callback
	 */
	public function table($table, \Closure $callback)
	{
		try
		{
			parent::create($table, $callback);
		}
		catch(\Exception $e)
		{
			try
			{
				parent::table($table, $callback);
			}
			catch(\Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}

	/**
	 * Somehow bugged, so i fix it there.
	 * Get the column listing for a given table.
	 *
	 * @param  string  $table
	 * @return array
	 */
	public function getColumnListing($table)
	{
		$table = $this->connection->getTablePrefix().$table;

		$results = $this->connection->select($this->grammar->compileColumnExists($table), array($this->connection->getDatabaseName(), $table));

		return $this->connection->getPostProcessor()->processColumnListing($results);
	}

	public function createBlueprint($table, \Closure $closure = null)
	{
		return new Blueprint($table, $closure, $this);
	}
}