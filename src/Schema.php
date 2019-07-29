<?php

namespace Laraquent;

use Closure;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;

class Schema extends Builder
{
    protected $existingIndexes;
    protected $existingIndexKeys = [];
    protected $pdo;

    public function __construct(Connection $connection)
    {
        if(!$connection->getSchemaGrammar())
            $connection->useDefaultSchemaGrammar();

        $this->pdo = $connection->getPdo();

        parent::__construct($connection);
    }

    public function indexesCheck()
    {

    }

    public function hasIndex($table, $column)
    {
        if (in_array($column, $this->existingIndexKeys[$table]))
            return true;

        return in_array($column, $this->existingIndexes[$table]);
    }

    public function hasTable($table)
    {
//        $statement = $this->pdo->query('SELECT ' . $table . " FROM information_schema.tables WHERE table_schema = '" . $dbname . "' AND table_name = '" . $table . "'");
        $statement = $this->pdo->query("SHOW TABLES LIKE '" . $table . "'");

        return count($statement->fetchAll()) > 0;
    }

    /**
     * Create a new table on the schema.
     *
     * @param  string    $table
     * @param  \Closure  $callback
     * @return void
     */
    public function create($table, Closure $callback)
    {
        $this->build(tap($this->createBlueprint($table), function (Blueprint $blueprint) use ($callback) {
            $blueprint->create();

            $callback($blueprint);
        }));
    }

    /**
     * Create table if not exist.
     * @param string table
     * @param \Closure $callback
     */
    public function table($table, \Closure $callback)
    {
        $this->existingIndexes[$table] = [];
        $this->existingIndexKeys[$table] = [];

        if ($this->hasTable($table)) {
            // fetch existing indexes
            $statement = $this->pdo->query('SHOW INDEX FROM ' . $table);

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                $this->existingIndexes[$table][] = $data['Column_name'];
                $this->existingIndexKeys[$table][] = $data['Key_name'];
            }
        }

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
        $table = $this->connection->getTablePrefix() . $table;

        $results = $this->connection->select($this->grammar->compileColumnListing(
            $table
        ), array($this->connection->getDatabaseName(), $table));

        return $this->connection->getPostProcessor()->processColumnListing($results);/*

        $table = $this->connection->getTablePrefix().$table;
        $results = $this->connection->select($this->grammar->compileForeign(), array($this->connection->getDatabaseName(), $table));
        return $this->connection->getPostProcessor()->processColumnListing($results);*/
    }
    public function createBlueprint($table, \Closure $closure = null)
    {
        return new Blueprint($table, $closure, $this);
    }
}