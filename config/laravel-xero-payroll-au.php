<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Xero Payroll AU Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Laravel Xero Payroll will be accessible from. Feel free
    | to change this path to anything you like.
    |
    */

    'path' => env('LARAVEL_XERO_PAYROLL_AU_PATH', 'xero-payroll'),

    /*
    |--------------------------------------------------------------------------
    | Laravel Xero Payroll AU Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Laravel Xero Payroll AU route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web',
        'auth',
    ],
];