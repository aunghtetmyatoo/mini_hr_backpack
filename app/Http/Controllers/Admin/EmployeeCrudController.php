<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setColumns(['name', 'email', 'phone_number', 'address', 'salary_rate']);

        CRUD::addColumn([
            'name' => 'photo',
            'type' => 'image',
            'label' => 'Photo',
        ]);
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
        CRUD::setValidation(EmployeeRequest::class);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Employee Name",
        ]);
        CRUD::addField([
            'name' => 'email',
            'type' => 'text',
            'label' => "Email",
        ]);
        CRUD::addField([
            'name' => 'phone_number',
            'type' => 'text',
            'label' => "Phone Number",
        ]);
        CRUD::addField([   // Browse
            'name'  => 'nrc_front',
            'label' => 'NRC Front',
            'type'  => 'browse'
        ]);
        CRUD::addField([
            'name' => 'nrc_back',
            'type' => 'browse',
            'label' => "NRC Back",
        ]);
        CRUD::addField([
            'name' => 'photo',
            'type' => 'browse',
            'label' => "Employee Photo",
        ]);
        CRUD::addField([
            'name' => 'address',
            'type' => 'textarea',
            'label' => "Address",
        ]);
        CRUD::addField([
            'name' => 'salary_rate',
            'type' => 'text',
            'label' => "Salary Rate",
        ]);
        CRUD::addField([  // Select2
            'label'     => "Position",
            'type'      => 'select2',
            'name'      => 'position_id', // the db column for the foreign key
         
            // optional
            'entity'    => 'position', // the method that defines the relationship in your Model
            'model'     => "App\Models\Position", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 2, // set the default value of the select2
         
         ]);


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
}
