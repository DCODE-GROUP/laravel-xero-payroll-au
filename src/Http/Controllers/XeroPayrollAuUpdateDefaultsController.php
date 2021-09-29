<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class XeroPayrollAuUpdateDefaultsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        // dispatch the job

        // Update the values here

        return redirect()->route('xero_payroll.index');
    }
}
