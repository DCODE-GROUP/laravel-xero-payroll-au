<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Jobs;

use Dcodegroup\LaravelConfiguration\Models\Configuration;
use Dcodegroup\LaravelXeroPayrollAu\BaseXeroPayrollAuService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncPayrollConfigurationOptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = config('laravel-xero-payroll-au.queue');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = resolve(BaseXeroPayrollAuService::class);

        $calendars = $service->getPayrollCalendars();
        Configuration::byKey('xero_payroll_calendars')->update(['value' => $calendars->toArray()]);

        $leaveTypes = $service->getLeaveTypes();
        Configuration::byKey('xero_leave_types')->update(['value' => $leaveTypes->toArray()]);

        $earningRates = $service->getEarningRates();
        Configuration::byKey('xero_earnings_rates')->update(['value' => $earningRates->toArray()]);
    }
}
