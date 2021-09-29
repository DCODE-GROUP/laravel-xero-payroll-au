<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use Dcodegroup\LaravelXeroOauth\BaseXeroService;
use XeroPHP\Models\PayrollAU\PayrollCalendar;

class BaseXeroPayrollAuService extends BaseXeroService
{
    public function getPayrollCalendars()
    {
        return $this->xeroClient->getModel(PayrollCalendar::class);
    }

}
