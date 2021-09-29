<?php

use Dcodegroup\LaravelXeroPayrollAu\Http\Controllers\XeroPayrollAuController;
use Dcodegroup\LaravelXeroPayrollAu\Http\Controllers\XeroPayrollAuSyncDataController;
use Dcodegroup\LaravelXeroPayrollAu\Http\Controllers\XeroPayrollAuUpdateDefaultsController;
use Illuminate\Support\Facades\Route;

Route::get('/', XeroPayrollAuController::class)->name('index');
Route::get('/pull-data', XeroPayrollAuSyncDataController::class)->name('sync');
Route::get('/update', XeroPayrollAuUpdateDefaultsController::class)->name('update');
//Route::post('/tenants/{tenantId}/', SwitchXeroTenantController::class)->name('tenant.update');