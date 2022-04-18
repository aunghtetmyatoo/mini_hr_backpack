<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('position', 'PositionCrudController');
    Route::crud('attendance', 'AttendanceCrudController');
    Route::crud('salary', 'SalaryCrudController');
    Route::get('charts/employee-by-position', 'Charts\EmployeeByPositionChartController@response')->name('charts.employee-by-position.index');
    Route::get('charts/number-of-employees', 'Charts\NumberOfEmployeesChartController@response')->name('charts.number-of-employees.index');
}); // this should be the absolute last line of this file