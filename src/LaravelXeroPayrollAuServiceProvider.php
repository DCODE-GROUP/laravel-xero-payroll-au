<?php

namespace Dcodegroup\LaravelXeroOauth;

use Calcinai\OAuth2\Client\Provider\Xero;
use Dcodegroup\LaravelXeroOauth\Commands\InstallCommand;
use Dcodegroup\LaravelXeroOauth\Exceptions\XeroOrganisationExpired;
use Dcodegroup\LaravelXeroOauth\Models\XeroToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use XeroPHP\Application;

class LaravelXeroPayrollAuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->offerPublishing();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->mergeConfigFrom(__DIR__ . '/../config/laravel-xero-oauth.php', 'laravel-xero-oauth');

        $this->app->singleton(Xero::class, function () {
            return new Xero([
                                'clientId' => config('laravel-xero-oauth.oauth.client_id'),
                                'clientSecret' => config('laravel-xero-oauth.oauth.client_secret'),
                                'redirectUri' => route(config('laravel-xero-oauth.path') . '.callback'),
                            ]);
        });

        $this->app->bind(Application::class, function () {
            $client = resolve(Xero::class);

            $token = XeroTokenService::getToken();

            if (! $token) {
                return new Application('fake_id', 'fake_tenant');
            }

            $latest = XeroToken::latestToken();
            $tenantId = $latest->current_tenant_id;

            if (is_null($latest->current_tenant_id)) {
                $tenant = head($client->getTenants($token));
                $tenantId = $tenant->tenantId;
            }

            if (! $tenantId) {
                throw new XeroOrganisationExpired('There is no configured organisation or the organisation is expired!');
            }

            return new Application($token->getToken(), $tenantId);
        });

        $this->app->bind(BaseXeroPayrollService::class, function () {
            return new BaseXeroPayrollService(resolve(Application::class));
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
        if (! Schema::hasTable('xero_tokens') && ! class_exists('CreateXeroTokensTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                                 __DIR__ . '/../database/migrations/create_xero_tokens_table.php.stub.php' => database_path('migrations/' . $timestamp . '_create_xero_tokens_table.php'),
                             ], 'laravel-xero-oauth-migrations');
        }

        $this->publishes([__DIR__ . '/../config/laravel-xero-oauth.php' => config_path('laravel-xero-oauth.php')], 'laravel-xero-oauth-config');
    }
    
    protected function registerResources()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'xero-oauth-translations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'xero-oauth-views');
    }

    protected function registerRoutes()
    {
        Route::group([
                         'prefix' => config('laravel-xero-oauth.path'),
                         'as' => config('laravel-xero-oauth.path') . '.',
                         'middleware' => config('laravel-xero-oauth.middleware', 'web'),
                     ], function () {
                         $this->loadRoutesFrom(__DIR__ . '/../routes/xero.php');
                     });
    }
}
