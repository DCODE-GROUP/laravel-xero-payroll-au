<?php

namespace Dcodegroup\LaravelXeroPayrollAu;

use XeroPHP\Application;

class BaseXeroPayrollAuService
{
    public Application $xeroClient;

    public function __construct(Application $xeroClient)
    {
        $this->xeroClient = $xeroClient;
    }
    
    
}
