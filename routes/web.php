<?php

use App\Http\Controllers\Admin\AttendanceCrudController;
use App\Http\Controllers\Admin\Charts\DashboardController;
use App\Http\Controllers\Admin\Charts\EmployeeByPositionChartController;
use App\Http\Controllers\Admin\SalaryCrudController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/admin/attendance', [AttendanceCrudController::class, 'attendanceList'])->name('attendance.index');
Route::get('/admin/attendance', [AttendanceCrudController::class, 'attendanceList'])->name('attendance.index');
Route::get('/admin/attendance/create', [AttendanceCrudController::class, 'attendanceCreate'])->name('attendance.create');
Route::post('/admin/attendance/create', [AttendanceCrudController::class, 'attendanceCreate'])->name('attendance.create');
Route::post('/admin/attendance/morning', [AttendanceCrudController::class, 'morning']);
Route::post('/admin/attendance/evening', [AttendanceCrudController::class, 'evening']);

// Route::get('/admin/salary', [SalaryCrudController::class, 'salaryCreate'])->name('salary.index');
Route::get('/admin/salary/create', [SalaryCrudController::class, 'salaryCreate'])->name('salary.create');
Route::post('/admin/salary/create', [SalaryCrudController::class, 'salarySave'])->name('salary.save');
Route::get('/admin/salary/show/slip', [SalaryCrudController::class, 'salarySlip'])->name('salary.slip');

Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/admin/attendance/report', [AttendanceCrudController::class, 'report'])->name('attendance.report');
Route::post('/admin/attendance/report', [AttendanceCrudController::class, 'report_table'])->name('attendance.report_table');
Route::post('/admin/attendance/report_export', [AttendanceCrudController::class, 'export'])->name('attendance.export');


