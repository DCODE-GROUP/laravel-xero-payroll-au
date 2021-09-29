<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Dcodegroup\LaravelXeroPayrollAu\Jobs\SyncPayrollConfigurationOptions;
use Illuminate\Http\RedirectResponse;

class XeroPayrollAuSyncDataController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        SyncPayrollConfigurationOptions::dispatch();

        return redirect()->route('xero_payroll.index');
    }
}
