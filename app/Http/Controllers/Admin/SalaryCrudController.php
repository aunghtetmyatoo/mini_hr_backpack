<?php

namespace App\Http\Controllers\Admin;

use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\SalaryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SalaryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalaryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Salary::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/salary');
        CRUD::setEntityNameStrings('salary', 'salaries');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    
    protected function setupListOperation()
    {
        CRUD::addColumn([
            // 1-n relationship
            'label'     => 'Employee Name', // Table column heading
            'type'      => 'select',
            'name'      => 'employee_id', // the column that contains the ID of that connected entity;
            'entity'    => 'employee', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Employee", // foreign key model
        ],);
        CRUD::addColumn([
            'name' => 'leave_day',
            'type' => 'float',
            'label'=> 'Leave Day'
        ]);
        CRUD::addColumn([
            'name' => 'leave_amount',
            'type' => 'float',
            'label'=> 'Leave Amount'
        ]);
        CRUD::addColumn([
            'name' => 'salary',
            'type' => 'float',
            'label'=> 'Net Salary'
        ]);
        CRUD::addColumn([
            'name'  => 'created_at', // The db column name
            'label' => 'Date', // Table column heading
            'type'  => 'date',
            'format' => 'MMM Y', // use something else than the base.default_date_format config value
        ]);

        // CRUD::setColumns(['leave_day', 'leave_amount', 'salary']);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SalaryRequest::class);

        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function salaryCreate()
    {
        $employees = Employee::all();
        $attendances = Attendance::all();
        
        return view('salary.create', compact('employees', 'attendances'));
    }

    public function salarySave(Request $request)
    {
        foreach($request['employee_id'] as $key=>$value){
            $month = Salary::whereMonth('created_at', Carbon::today()->month)->first();

            if($month){
                $month->employee_id = $request['employee_id'][$key];
                $month->leave_day = $request['leave_day'][$key];
                $month->leave_amount = $request['leave_amount'][$key];
                $month->salary = $request['salary'][$key];
    
                $month->save();
        
                return redirect()->route('salary.index');
            } else {
                foreach($request['employee_id'] as $key=>$value){
                    $salary = new Salary;
    
                    $salary->employee_id = $request['employee_id'][$key];
                    $salary->leave_day = $request['leave_day'][$key];
                    $salary->leave_amount = $request['leave_amount'][$key];
                    $salary->salary = $request['salary'][$key];
        
                    $salary->save();
                }

                return redirect()->route('salary.index');
            }
        }
    }

    public function salarySlip()
    {
        $employees = Employee::all();
        $attendances = Attendance::all();

        return view('salary.show', compact('employees', 'attendances'));
    }
}
