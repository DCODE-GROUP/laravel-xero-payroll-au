<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use Dcodegroup\LaravelXeroPayrollAu\Commands\InstallCommand;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use XeroPHP\Application;

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
        $this->registerResponseHandler();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-xero-payroll-au.php', 'laravel-xero-payroll-au');

        $this->app->bind(BaseXeroPayrollAuService::class, function () {
            return new BaseXeroPayrollAuService(resolve(Application::class));
        });
    }

    /**
     * Setup the resource publishing groups for Dcodegroup Xero oAuth.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([__DIR__.'/../config/laravel-xero-payroll-au.php' => config_path('laravel-xero-payroll-au.php')], 'laravel-xero-payroll-au-config');
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
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'xero-payroll-au-translations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xero-payroll-au-views');
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('laravel-xero-payroll-au.path'),
            'as' => Str::slug(config('laravel-xero-payroll-au.path'), '_').'.',
            'middleware' => config('laravel-xero-payroll-au.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/xero_payroll_au.php');
        });
    }

    /**
     * Listen to the RequestHandled event to prepare the Response.
     *
     * @return void
     */
    private function registerResponseHandler()
    {
        Event::listen(RequestHandled::class, function (RequestHandled $event) {
            if (! $event->request->ajax() &&
                (($event->response->headers->has('Content-Type') && strpos($event->response->headers->get('Content-Type'), 'html') === true)
                    || $event->request->getRequestFormat() == 'html'
                    || stripos($event->response->headers->get('Content-Disposition'), 'attachment;') === false) &&
                Str::startsWith($event->request->route()?->getName(), Str::slug(config('laravel-xero-payroll-au.path')).'.')) {
                $content = $event->response->getContent();

                $head = View::make('xero-payroll-au-views::head')->render();

                // Try to put the js/css directly before the </head>
                $pos = strripos($content, '</head>');
                if ($pos !== false) {
                    $content = substr($content, 0, $pos).$head.substr($content, $pos);
                }

                $original = null;
                if ($event->response instanceof IlluminateResponse && $event->response->getOriginalContent()) {
                    $original = $event->response->getOriginalContent();
                }

                $event->response->setContent($content);

                // Restore original response (eg. the View or Ajax data)
                if ($original) {
                    $event->response->original = $original;
                }
            }
        });
    }
}
