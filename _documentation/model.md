# Model


## Dynaic model table

https://stackoverflow.com/questions/37484924/dynamic-table-name-for-laravel-model

usage:
```

$project = new \App\Models\Eloquent\MakeModel();
$project->setTable('table_name');
$project->data = ['hello' => 'dolly'];
$project->save();

or

$data = \App\Models\Eloquent\MakeModel::query()
->table('table_name')
->where('data', 'like', '%dolly%')
->get();

```