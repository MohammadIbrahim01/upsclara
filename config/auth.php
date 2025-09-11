<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard'     => 'web',      // Admin panel default
        'passwords' => 'users',    // Admin users password reset
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'sanctum' => [
            'driver'   => 'sanctum',   // Frontend API users
            'provider' => 'frontend_users',
        ],

        'api' => [
            'driver'   => 'token',      // Legacy API token (optional)
            'provider' => 'frontend_users',
            'hash'     => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,          // Admin panel user
        ],

        'frontend_users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\FrontendUser::class,  // API user
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],

        'frontend_users' => [
            'provider' => 'frontend_users',
            'table'    => 'frontend_password_resets',  // Optional separate table
            'expire'   => 60,
        ],
    ],

];
