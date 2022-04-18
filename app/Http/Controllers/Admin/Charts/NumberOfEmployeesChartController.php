<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Employee;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Backpack\CRUD\app\Http\Controllers\ChartController;

/**
 * Class NumberOfEmployeesChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NumberOfEmployeesChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart;

        // $employees = Employee::count();
        $january = Employee::where('created_at', 'LIKE', '%' . '2022-01' . '%')->get()->count(); 
        $february = Employee::where('created_at', 'LIKE', '%' . '2022-02' . '%')->get()->count(); 
        $march = Employee::where('created_at', 'LIKE', '%' . '2022-03' . '%')->get()->count(); 
        $april = Employee::where('created_at', 'LIKE', '%' . '2022-04' . '%')->get()->count(); 
        $may = Employee::where('created_at', 'LIKE', '%' . '2022-05' . '%')->get()->count(); 
        $june = Employee::where('created_at', 'LIKE', '%' . '2022-06' . '%')->get()->count(); 
        $july = Employee::where('created_at', 'LIKE', '%' . '2022-07' . '%')->get()->count(); 
        $august = Employee::where('created_at', 'LIKE', '%' . '2022-08' . '%')->get()->count(); 
        $september = Employee::where('created_at', 'LIKE', '%' . '2022-09' . '%')->get()->count(); 
        $october = Employee::where('created_at', 'LIKE', '%' . '2022-10' . '%')->get()->count(); 
        $november = Employee::where('created_at', 'LIKE', '%' . '2022-11' . '%')->get()->count(); 
        $december = Employee::where('created_at', 'LIKE', '%' . '2022-12' . '%')->get()->count(); 



        $this->chart->dataset('Number of Employees', 'line', [$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december]);

        // OPTIONAL
        $this->chart->displayAxes(true);
        $this->chart->displayLegend(false);

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Novembar', 'December']);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    // public function data()
    // {
    //     $users_created_today = \App\User::whereDate('created_at', today())->count();

    //     $this->chart->dataset('Users Created', 'bar', [
    //                 $users_created_today,
    //             ])
    //         ->color('rgba(205, 32, 31, 1)')
    //         ->backgroundColor('rgba(205, 32, 31, 0.4)');
    // }
}