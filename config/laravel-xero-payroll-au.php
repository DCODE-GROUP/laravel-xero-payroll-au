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

    /*
    |--------------------------------------------------------------------------
    | Laravel Xero Payroll AU Job Queue
    |--------------------------------------------------------------------------
    |
    | This will allow you to configure queue to use for background jobs
    |
    */
    'queue' => env('LARAVEL_XERO_PAYROLL_AU_QUEUE', 'default'),

    /*
     * --------------------------------------------------------------------------
     * Laravel Xero Payroll AU Layout
     * --------------------------------------------------------------------------
     *
     * The name of the base layout to wrap the pages in.
     * The exposed routes will have to know the layout of the app in order to
     * appear to look like the rest of the site. If one is not set then the internal one will be used.
     *
     */

    'app_layout' => env('LARAVEL_XERO_PAYROLL_AU_LAYOUT', 'xero-payroll-au-views::layout'),
];