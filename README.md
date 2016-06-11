# laraquent
An out of laravel eloquent use, for a quick access to different microframeworks, and several extended uses.

### Extends schema Builder and Blueprint
- addColumn now check for existing columns in db
- Schema\Builder::table now create if table does not exist

#### Active schema
Every executed table() method will be listened as either create or alter, then make a changes accordingly
```
$schema->table('Book', function($table) {
    $table->increments('id');
    $table->string('title');
    $table->string('isbn');
    $table->timestamps();
});
```

### Prefixed relation method
- extended model that relation method now is to be prefixed with 'relate'.

