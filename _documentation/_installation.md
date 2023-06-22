
# Requirement

enable php.ini

extension=pdo_sqlite  

# Instalation

STEP 

```
composer install
```

```
npm install
npm run dev
```

STEP 

```
php artisan key:generate
```


STEP 

```
php artisan migrate:fresh --seed
```

STEP 

new project

```
php artisan permissions:sync
php artisan permissions:sync -P
php artisan filament:upgrade
```
jika migrate fresh tanpa create policy folder
```
php artisan permissions:sync
```

STEP 

generate role dan menambahkan role ke user

```
php artisan db:seed AssignRoleSeeder
```







COMMAND LAIN JIKA PERLU:

https://github.com/althinect/filament-spatie-roles-permissions

auto generate permission dari page filament ke db permission

```
php artisan permissions:sync
```

reset delete semua permision dan auto generate permission
```
php artisan permissions:sync -C
```


auto generate Policies  `` app/Policies``

diambil dari table permission
```
php artisan permissions:sync -P
```

RESET, Geneerate terbaru
```
php artisan permissions:sync -C
php artisan permissions:sync
rm -v .\app\Policies\*
php artisan permissions:sync -P
```

This will override existing policy classes
```
php artisan permissions:sync -O
```	
#### artisan
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear



