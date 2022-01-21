<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Dcodegroup\LaravelConfiguration\Models\Configuration;
use Illuminate\Contracts\View\View;

class XeroPayrollAuController extends Controller
{
    public function __invoke(): View
    {
        return view('xero-payroll-au-views::index')
            ->with('configurations', Configuration::byGroup('xero_payroll_au')->get());
    }
}
