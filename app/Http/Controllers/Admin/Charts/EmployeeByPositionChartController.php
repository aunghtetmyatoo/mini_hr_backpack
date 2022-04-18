<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Library\Widget;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
// use ConsoleTVs\Charts\Classes\Echarts\Chart;
// use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
// use ConsoleTVs\Charts\Classes\Highcharts\Chart;
// use ConsoleTVs\Charts\Classes\C3\Chart;
// use ConsoleTVs\Charts\Classes\Frappe\Chart;

use Backpack\CRUD\app\Http\Controllers\ChartController;

/**
 * Class EmployeeByPositionChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeByPositionChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart;

        $manager = DB::table('employees')
                ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
                ->where('positions.name', 'Manager')
                ->count();
        $leader = DB::table('employees')
                ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
                ->where('positions.name', 'Leader')
                ->count();
        $senior = DB::table('employees')
                ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
                ->where('positions.name', 'Senior')
                ->count();
        $junior = DB::table('employees')
                ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
                ->where('positions.name', 'Junior')
                ->count();

        $this->chart->dataset('EmployeeByPosition', 'pie', [$manager, $leader, $senior, $junior])
                    ->backgroundColor([
                        'rgb(70, 127, 208)',
                        'rgb(77, 189, 116)',
                        'rgb(96, 92, 168)',
                        'rgb(255, 193, 7)',
                    ]);

        // OPTIONAL
        $this->chart->displayAxes(false);
        $this->chart->displayLegend(true);

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['Manager', 'Leader', 'Senior', 'Junior']);
        
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