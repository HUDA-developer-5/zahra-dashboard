<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Advertisement\PremiumCommissionTypeEnums;
use App\Http\Requests\Admin\PremiumCommissionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PremiumCommissionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PremiumCommissionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PremiumCommission::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/premium-commission');
        CRUD::setEntityNameStrings('premium commission', 'premium commissions');
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
            "label" => 'Commission',
            "name" => "commission"
        ]);

        $this->crud->addColumn([
            "label" => 'Type',
            "name" => "type",
            "type" => "enum",
            'options' => PremiumCommissionTypeEnums::asArray()
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
        CRUD::setValidation(PremiumCommissionRequest::class);
//        $this->crud->addField([
//            "label" => 'Days',
//            "name" => "days",
//            'type' => 'number',
//            'attributes' => ['min' => 1],
//        ]);

//        $this->crud->addField([
//            "label" => 'Type',
//            "name" => "type",
//            "type" => "enum",
//            'options' => PremiumCommissionTypeEnums::asArray()
//        ]);
        $this->crud->addField([
            "label" => 'Commission',
            "name" => "commission",
            'type' => 'number',
            'attributes' => ["step" => "any", 'min' => 0.1, 'max' => 99],
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
