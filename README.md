# laraquent
An out of laravel eloquent 5.1 use, for a quick access to different microframeworks, and several extended uses.

### Usage
Prepare the eloquent capsule using it's very own documentation
https://github.com/illuminate/database

### Extends schema Builder and Blueprint
- addColumn() now check for existing columns in db
- Schema\Builder::table now create if table does not exist

#### Active schema migration
table() method may now be used to listen to existing database, to perform either create or alter table, it will make changes to database accordingly.
- create table if the table doesn't exist.
- add column for existing table
- does not drop table
- does not drop column
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
Relation method now is to be prefixed with 'relate'. Example :
```
class Article extends \Laraquent\Base
{
    public function relateAuthor()
    {
        return $this->hasOne('\App\Entity\Author', 'author_id');
    }
}
```

### As a service provider
Provide as a service to different microframeworks
#### \Exedra
Basically the provider will instatiate the eloquent capsule, and register a service with name 'eloquent'.
```
$app->config->set('db', array(
    'host' => 'localhost',
    'name' => 'my_db',
    'user' => 'root',
    'password' => 'password'
));

$app->provider->add(\Laraquent\Support\Provider\Exedra::class);
```
##### Active schema migration
- Add a model:migrate console command, and will look for {root}/database/schema.php
  - or configure db.schema_path (relative to root)
```
$app->config->set('db.schema_path', 'database/schema.php');
```
database/schema.php file will be loaded, with an extracted $schema variable.
```
$schema->table('Author', function() {
    $table->increments('id');
    $table->string('name');
    $table->timestamps();
});
```

Command use (assuming console access name is 'wizard') :
```
php wizard model:migrate
```

### Special thanks
Special thanks to Taylor Otwell, and Laravel communities for making an awesome framework, and for making it possible to use eloquent outside of larevel. 
