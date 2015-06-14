# Laravel Sidebar v1.0.0

##Installation

Require this package in your `composer.json` and run `composer update`.

```php
"maatwebsite/laravel-sidebar": "~2.0.0"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
'Maatwebsite\Sidebar\SidebarServiceProvider',
```

To publish the default views use:

```php
php artisan vendor:publish --tag="views"
```
