<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FreeCommissionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FreeCommissionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FreeCommissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\FreeCommission::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/free-commission');
        CRUD::setEntityNameStrings('free commission', 'free commissions');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            "label" => 'ID',
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Days',
            "name" => "days"
        ]);

        $this->crud->addColumn([
            "label" => 'Limit',
            "name" => "limit"
        ]);

        $this->crud->addColumn([
            "label" => 'Ads Commission Percentage',
            "name" => "commission_percentage"
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FreeCommissionRequest::class);
        $this->crud->addField([
            "label" => 'Days',
            "name" => "days",
            'type' => 'number',
            'attributes' => ['min' => 1],
        ]);

        $this->crud->addField([
            "label" => 'Limit',
            "name" => "limit",
            'type' => 'number',
            'attributes' => ['min' => 1],
        ]);

        $this->crud->addField([
            "label" => 'Ads Commission Percentage',
            "name" => "commission_percentage",
            'type' => 'number',
            'attributes' => ['min' => 1],
        ]);
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
