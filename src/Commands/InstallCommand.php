<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-xero-payroll-au:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Laravel Xero Payroll AU resources';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Make sure the dcodegroup/laravel-configuration package has the database table installed');

        /**
         * Need a way to check that the  CreateConfigurationTable does not exist in migrations
         */
        if (! Schema::hasTable('configurations') && ! class_exists('CreateConfigurationTable')) {
            $this->comment('Publishing Laravel Configurations Migrations');
            $this->callSilent('vendor:publish', ['--tag' => 'laravel-configurations-migrations']);

            $this->call('migrate');
            $this->comment('Laravel Configurations Migrations have been run');

        }

        //if (! Schema::hasTable('xero_tokens') && class_exists('CreateXeroTokensTable')) {
        //    $this->comment('Publishing Laravel Xero Migrations');
        //    $this->callSilent('vendor:publish', ['--tag' => 'laravel-xero-oauth-migrations']);
        //}
        //
        //$this->comment('Publishing Laravel Xero Configuration...');
        //$this->callSilent('vendor:publish', ['--tag' => 'laravel-xero-oauth-config']);
        //
        //$this->info('Laravel Xero scaffolding installed successfully.');
    }
}
