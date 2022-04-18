<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Input\Input;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AttendanceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttendanceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Attendance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attendance');
        CRUD::setEntityNameStrings('attendance', 'attendances');

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    protected function setupListOperation()
    {
        // CRUD::setColumns(['employee_id', 'morning', 'evening', 'created_at']);
        CRUD::addColumn([
            // 1-n relationship
            'label' => 'Employee Name', // Table column heading
            'type' => 'select',
            'name' => 'employee_id', // the column that contains the ID of that connected entity;
            'entity' => 'employee', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\Employee', // foreign key model
        ], );
        CRUD::addColumn([
            'name' => 'morning', // The db column name
            'label' => 'Morning Attendance', // Table column heading
            'type' => 'check',
        ], );
        CRUD::addColumn([
            'name' => 'evening', // The db column name
            'label' => 'Evening Attendance', // Table column heading
            'type' => 'check',
        ], );
        CRUD::addColumn([
            'name' => 'created_at', // The db column name
            'label' => 'Date', // Table column heading
            'type' => 'date',
        ], );

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
        CRUD::setValidation(AttendanceRequest::class);

        CRUD::addField([ // date_picker
            'name' => 'date',
            'type' => 'date_picker',
            'label' => 'Date',
        ], );
        CRUD::addField([ // Select2
            'label' => "Employee",
            'type' => 'select2',
            'name' => 'employee_id', // the db column for the foreign key

            // optional
            'entity' => 'employee', // the method that defines the relationship in your Model
            'model' => "App\Models\Employee", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default' => 2, // set the default value of the select2

        ]);
        CRUD::addField([ // Checkbox
            'name' => 'morning',
            'label' => 'Morning Attendance',
            'type' => 'checkbox',
        ]);
        CRUD::addField([ // Checkbox
            'name' => 'evening',
            'label' => 'Evening Attendance',
            'type' => 'checkbox',
        ], );

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

    public function attendanceList(Request $request)
    {
        $date = $request->search;
        $attendances = Attendance::where('created_at', 'LIKE', '%' . $date . '%')->get();
        
        return view('attendance.list', compact('attendances', 'date'));
    }

    public function attendanceCreate(Request $request)
    {
        $date = $request->search;
        if(!$date) {
            $date = date('Y-m-d');
        }
        $employees = Employee::all();
        $attendances = Attendance::where('created_at', 'LIKE', '%' . $date . '%')->get();

        if(count($attendances)<1 and $date == date('Y-m-d')){
            foreach($employees as $employee){
                $attendance = new Attendance();
                $attendance->employee_id = $employee->id;
                $attendance->morning = false;
                $attendance->evening = false;
                $attendance->save();
            }
        }
        return view('attendance.create', compact('employees', 'attendances', 'date'));
    }

    public function morning(Request $request)
    {
        $attendance = Attendance::where('employee_id', $request->employee_id)->whereDate('created_at', $request->date)->first();
        if($attendance){
            $attendance->morning = $request->morning_checkbox == 'true' ? 1 : 0;
            $attendance->update();
        }else{
            $attendance = new Attendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->morning = $request->morning_checkbox == 'true' ? 1 : 0;
            $attendance->created_at = $request->date;
            $attendance->save();
        }

        return ['result' => 1, 'message' => 'Successfully updated.'];
    }

    public function evening(Request $request)
    {
        $attendance = Attendance::where('employee_id', $request->employee_id)->whereDate('created_at', $request->date)->first();
        if($attendance){
            $attendance->evening = $request->evening_checkbox == 'true' ? 1 : 0;
            $attendance->update();
        }else{
            $attendance = new Attendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->evening = $request->evening_checkbox == 'true' ? 1 : 0;
            $attendance->created_at = $request->date;
            $attendance->save();
        }

        return ['result' => 1, 'message' => 'Successfully updated.'];
    }

    public function report(Request $request)
    {
        $date = $request->search;
       
        $employees = Employee::all();

        return view('attendance.report', compact('date', 'employees'));
    }

    public function report_table(Request $request)
    {
       $attendances = Attendance::whereBetween('created_at', [$request->from, $request->to])->whereIn('employee_id', $request->employee_id)->orderBy('employee_id', 'asc')->get();

        return view('attendance.report-table', compact('attendances'))->render();
    }

    public function export(Request $request)
    {
        dd('ehllo');
        $items = collect($request->input('items', []));

        return (new FastExcel($items))->download('file.xlsx');

    }

}
