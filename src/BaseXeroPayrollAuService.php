<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use Dcodegroup\LaravelXeroOauth\BaseXeroService;
use XeroPHP\Models\PayrollAU\PayItem;
use XeroPHP\Models\PayrollAU\PayrollCalendar;

class BaseXeroPayrollAuService extends BaseXeroService
{
    public function getPayrollCalendars()
    {
        return $this->getModel(PayrollCalendar::class);
    }

    public function getLeaveTypes()
    {
        return $this->getModel(PayItem::class, null, 'LeaveTypes');
    }

    public function getEarningRates()
    {
        return $this->getModel(PayItem::class, null, 'EarningsRates');
    }
}
