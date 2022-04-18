<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard() {
        $employees = Employee::count();

        $leave_employees_by_day = Attendance::where('created_at', date('Y-m-d'))->where('morning', false)->where('evening', false)->count();


        $leave_employees = Salary::where('created_at', 'LIKE', '%' . '2022-04' . '%')->where('leave_day', '>=', 2)->get();
        
        return view('vendor.backpack.base.widgets.dashboard', compact('employees', 'leave_employees_by_day', 'leave_employees'));
    }
}
