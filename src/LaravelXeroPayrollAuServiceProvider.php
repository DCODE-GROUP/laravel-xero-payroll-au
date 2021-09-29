<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use Dcodegroup\LaravelXeroOauth\BaseXeroService;
use Dcodegroup\LaravelXeroPayrollAu\Commands\InstallCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelXeroPayrollAuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->offerPublishing();
        $this->registerCommands();
        $this->registerResources();
        $this->registerRoutes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-xero-payroll-au.php', 'laravel-xero-payroll-au');

        $this->app->bind(BaseXeroPayrollAuService::class, function () {
            return new BaseXeroPayrollAuService(resolve(BaseXeroService::class));
        });
    }

    /**
     * Setup the resource publishing groups for Dcodegroup Xero oAuth.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([__DIR__ . '/../config/laravel-xero-payroll-au.php' => config_path('laravel-xero-payroll-au.php')], 'laravel-xero-payroll-au-config');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                                InstallCommand::class,
                            ]);
        }
    }

    protected function registerResources()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'xero-payroll-au-translations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'xero-payroll-au-views');
    }

    protected function registerRoutes()
    {
        Route::group([
                         'prefix' => config('laravel-xero-payroll-au.path'),
                         'as' => Str::slug(config('laravel-xero-payroll-au.path'), '_') . '.',
                         'middleware' => config('laravel-xero-payroll-au.middleware', 'web'),
                     ], function () {
                         $this->loadRoutesFrom(__DIR__ . '/../routes/xero_payroll_au.php');
                     });
    }
}
