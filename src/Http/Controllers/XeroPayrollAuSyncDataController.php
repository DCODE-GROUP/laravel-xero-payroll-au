<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class XeroPayrollAuSyncDataController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        // dispatch the job

        return redirect()->route('xero_payroll.index');
    }
}