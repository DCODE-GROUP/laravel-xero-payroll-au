<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Commands;

use Dcodegroup\LaravelConfiguration\Models\Configuration;
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

    protected string $configurationGroup = 'xero_payroll';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Make sure the dcodegroup/laravel-configuration package has the database table installed');

        /**
         * Need a way to check that the  CreateConfigurationTable does not exist in migrations
         */
        if (!Schema::hasTable('configurations') && !class_exists('CreateConfigurationTable')) {
            $this->comment('Publishing Laravel Configurations Migrations');
            $this->callSilent('vendor:publish', ['--tag' => 'laravel-configurations-migrations']);

            $this->call('migrate');
            $this->comment('Laravel Configurations Migrations have been run');

        }

        $this->info('Store the configuration keys for this package');

        if (Configuration::byKey('xero_leave_types')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name'  => 'Xero Leave Types',
                                  ]);
        }

        if (Configuration::byKey('xero_earnings_rates')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name'  => 'Xero Earnings Rates',
                                  ]);
        }

        if (Configuration::byKey('xero_payroll_calendars')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name'  => 'Xero Payroll Calendars',
                                  ]);
        }

        if (Configuration::byKey('xero_default_payroll_calendar')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name'  => 'Xero Default Payroll Calendar',
                                  ]);
        }

    }
}

