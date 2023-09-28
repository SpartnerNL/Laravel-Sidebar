# Laravel Sidebar

[![GitHub release](https://img.shields.io/github/release/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://packagist.org/packages/maatwebsite/laravel-sidebar)
[![Travis](https://img.shields.io/travis/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://travis-ci.org/Maatwebsite/Laravel-Sidebar)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://github.com/Maatwebsite/Laravel-Sidebar)
[![Packagist](https://img.shields.io/packagist/dd/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://packagist.org/packages/maatwebsite/laravel-sidebar)
[![Packagist](https://img.shields.io/packagist/dm/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://packagist.org/packages/maatwebsite/laravel-sidebar)
[![Packagist](https://img.shields.io/packagist/dt/Maatwebsite/Laravel-Sidebar.svg?style=flat)](https://packagist.org/packages/maatwebsite/laravel-sidebar)

## Installation

Require this package in your `composer.json` and run `composer update`.

```php
"maatwebsite/laravel-sidebar": "~2.1"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
'Maatwebsite\Sidebar\SidebarServiceProvider',
```

Add the package middleware to `App\Http\Kernel`:

```php
`'Maatwebsite\Sidebar\Middleware\ResolveSidebars'`
```

To publish the default views use:

```php
php artisan vendor:publish --tag="views"
```

To publish the config use:

```php
php artisan vendor:publish --tag="config"
```

## Documentation

See the wiki: https://github.com/Maatwebsite/Laravel-Sidebar/wiki

## Contributing

**ALL contributions** should be made to appropriate branch (e.g. 2.0 for 2.0.* bug fixes). Bug fixes should never be sent to the master branch.

We follow PSR-1, PSR-2 and PSR-4 coding styles.

Added or fixed functionality should be backed with unit tests.

## License

This package is licensed under MIT. You are free to use it in personal and commercial projects.
