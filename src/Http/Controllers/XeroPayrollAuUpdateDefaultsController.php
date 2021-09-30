<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Controllers;

use App\Http\Controllers\Controller;
use Dcodegroup\LaravelConfiguration\Models\Configuration;
use Dcodegroup\LaravelXeroPayrollAu\Http\Requests\UpdatePayrollDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class XeroPayrollAuUpdateDefaultsController extends Controller
{
    public function __invoke(UpdatePayrollDefaults $request): RedirectResponse
    {
        // Update the values here

        $keys = $request->keys();

        Arr::forget($keys, '0');

        foreach ($keys as $field) {
            Configuration::byKey($field)->update(['value' => json_encode($request->input($field))]);
        }

        return redirect()->route('xero_payroll.index');
    }
}
