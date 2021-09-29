<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use Dcodegroup\LaravelXeroOauth\BaseXeroService;
use Dcodegroup\LaravelXeroOauth\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class LaravelXeroPayrollAuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->offerPublishing();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseXeroPayrollAuService::class, function () {
            return new BaseXeroPayrollAuService(resolve(BaseXeroService::class));
        });
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                                InstallCommand::class,
                            ]);
        }
    }

    /**
     * Setup the resource publishing groups for Dcodegroup Xero oAuth.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        //if (! Schema::hasTable('xero_tokens') && ! class_exists('CreateXeroTokensTable')) {
        //    $timestamp = date('Y_m_d_His', time());
        //
        //    $this->publishes([
        //                         __DIR__ . '/../database/migrations/create_xero_tokens_table.php.stub.php' => database_path('migrations/' . $timestamp . '_create_xero_tokens_table.php'),
        //                     ], 'laravel-xero-oauth-migrations');
        //}
        //
        //$this->publishes([__DIR__ . '/../config/laravel-xero-oauth.php' => config_path('laravel-xero-oauth.php')], 'laravel-xero-oauth-config');
    }
}
