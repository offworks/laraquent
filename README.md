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
#### \Exedra
- Basically it'll just instatiate the eloquent capsule, and set a service with name 'eloquent'.
```
$app->config->set('db', array(
    'host' => 'localhost',
    'name' => 'my_db',
    'user' => 'root',
    'password' => 'password'
));

$app->provider->add(\Laraquent\Support\Provider\Exedra::class);
```
##### Active schema migrate
- Add a model:migrate console command, and will look for {root}/database/schema.php
  - or configure db.schema_path (relative to root)
```
$app->config->set('db.schema_path', 'database/schema.php');
```
Command use (assuming console access name is 'wizard') :
```
php wizard model:migrate
```
