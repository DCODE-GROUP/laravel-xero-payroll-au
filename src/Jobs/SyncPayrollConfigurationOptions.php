<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Jobs;

use Dcodegroup\LaravelXeroPayrollAu\BaseXeroPayrollAuService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncPayrollConfigurationOptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BaseXeroPayrollAuService $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = config('laravel-xero-payroll-au.queue');
        $this->service = resolve(BaseXeroPayrollAuService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $calendar = $this->service->getPayrollCalendars();
    }
}
