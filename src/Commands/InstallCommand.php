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

    protected string $configurationGroup = 'xero_payroll_au';

    /**
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Laravel Xero Payroll AU Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-xero-payroll-au-config']);

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

        $this->info('Store the configuration keys for this package');

        if (Configuration::byKey('xero_leave_types')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Leave Types',
                                      'key' => 'xero_leave_types',
                                  ]);
        }

        if (Configuration::byKey('xero_earnings_rates')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Earnings Rates',
                                      'key' => 'xero_earnings_rates',
                                  ]);
        }

        if (Configuration::byKey('xero_payroll_calendars')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Payroll Calendars',
                                      'key' => 'xero_payroll_calendars',
                                  ]);
        }

        if (Configuration::byKey('xero_default_payroll_')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Default Payroll Calendar',
                                      'key' => 'xero_default_payroll_calendar',
                                  ]);
        }

        if (Configuration::byKey('xero_default_ordinary_earnings_rate_id')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Ordinary Earnings Rate (Time and a Half)',
                                      'key' => 'xero_default_ordinary_earnings_rate_id',
                                  ]);
        }

        if (Configuration::byKey('xero_default_time_and_a_half')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Overtime Earnings Rate (Time and a half)',
                                      'key' => 'xero_default_time_and_a_half',
                                  ]);
        }

        if (Configuration::byKey('xero_default_double_time')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'Overtime Earnings Rate (Double Time)',
                                      'key' => 'xero_default_double_time',
                                  ]);
        }
    }
}
