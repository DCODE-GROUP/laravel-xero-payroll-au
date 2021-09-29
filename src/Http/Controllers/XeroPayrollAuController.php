<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Dcodegroup\LaravelConfiguration\Models\Configuration;

class XeroPayrollAuController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('xero-payroll-au-views::index', [
            'configurations' => Configuration::byGroup('xero_payroll_au')->get(),
        ]);
    }
}