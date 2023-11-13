<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Define the way the Sidebar should be cached.
    | The cache store is defined by the Laravel
    |
    | Available: null|static|user-based
    |
    */
    'cache' => [
        'method'   => null,
        'duration' => 1440
    ],

    /*
    |--------------------------------------------------------------------------
    | View Name
    |--------------------------------------------------------------------------
    |
    | Choose a view to use to render the sidebar.
    | Built in templates are:
    |
    | - 'AdminLTE2'  - Bootstrap 3
    | - 'AdminLTE3'  - Bootstrap 4
    | - 'AdminLTE4'  - Bootstrap 5 (coming soon)
    | Or a custom view, for example 'custom'. [by default AdminLTE2 will be used so you can publish and modify it as you wish ].
    |
    */
    'view' => 'AdminLTE2',
];
