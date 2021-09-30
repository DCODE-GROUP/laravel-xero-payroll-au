<?php

namespace Dcodegroup\LaravelXeroPayrollAu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayrollDefaults extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'xero_default_time_and_a_half' => 'required',
            'xero_default_double_time' => 'required',
            'xero_default_payroll_calendar' => 'required',
        ];
    }
}
