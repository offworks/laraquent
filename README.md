# laraquent
An out of laravel eloquent 5.1 use, for a quick access to different microframeworks, and several extended uses.

### Usage
Prepare the eloquent capsule using it's very own documentation
https://github.com/illuminate/database

### Extends schema Builder and Blueprint
- addColumn() now check for existing columns in db
- Schema\Builder::table now create if table does not exist

#### Active schema
Every executed table() method will be listened as either create or alter, it will make the changes to database accordingly. It does not drop columns.
```
$connection = $capsule->getConnection();

$connection->useDefaultSchemaGrammar();

$schema = new \Laraquent\Schema($connection);

$schema->table('Book', function($table) {
    $table->increments('id');
    $table->string('title');
    $table->string('isbn');
    $table->timestamps();
});
```

### Prefixed relation method
- Relation method now is to be prefixed with 'relate'
