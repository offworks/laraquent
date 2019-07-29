# laraquent
A quick out of Laravel Eloquent 5.5 setup. 

I am just too lazy to figure out everything again everything I need to use eloquent. :p

More documentation can be found here :
- https://github.com/illuminate/database
- https://laravel.com/docs/master/eloquent

### Usage
Install through composer
```
composer require offworks/laraquent
```

Boot
```php
$capsule = \Laraquent\Factory::boot([
    'host' => 'localhost',
    'name' => 'mydb',
    'user' => 'root',
    'pass' = > ''
    ]);
```

### Active schema migration
table() method may now be used to listen to existing database, to perform either create or alter table, it will make changes to database accordingly.
- create table if the table does not exist.
- add column for existing table and skip exception if table doesn't exist
- does not drop table
- does not drop column
```php
$schema = new \Laraquent\Schema($capsule->getConnection());

$schema->table('Book', function($table) {
    $table->increments('id');
    $table->string('title');
    $table->string('isbn');
    $table->timestamps();
});
```

### Prefixed relation method
Relation method now is to be prefixed with 'relate', if you use the extended base model. Example :

```php
class Article extends \Laraquent\Entity
{
    public function relateAuthor()
    {
        return $this->hasOne('\App\Entity\Author', 'author_id');
    }
}
```

### Special thanks
Special thanks to Taylor Otwell, and Laravel communities for making an awesome framework, and for making it possible to use eloquent outside of larevel. 
