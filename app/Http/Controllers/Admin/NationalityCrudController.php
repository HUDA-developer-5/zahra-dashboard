<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonStatusEnums;
use App\Http\Requests\Admin\NationalityRequest;
use App\Traits\HasTranslatedField;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NationalityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NationalityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasTranslatedField;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Nationality::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/nationality');
        CRUD::setEntityNameStrings('nationality', 'nationalities');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Status',
        ], CommonStatusEnums::asArray()
            , function ($value) {
                $this->crud->addClause('where', 'status', $value);
            });

        $this->crud->addColumn([
            "label" => 'ID',
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Name',
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => 'Code',
            "name" => "code"
        ]);

        $this->crud->addColumn([
            "label" => 'Currency',
            "name" => "currency"
        ]);

        $this->crud->addColumn([
            "label" => 'Order',
            "name" => "order"
        ]);

        $this->crud->addColumn([
            "label" => 'Status',
            "name" => "status",
            "type" => "enum",
            'options' => CommonStatusEnums::asArray()
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
        CRUD::setValidation(NationalityRequest::class);

        $this->crud->addField([
            "name" => "status",
            "label" => 'Status',
            'type' => 'enum',
            "options" => CommonStatusEnums::asArray(),
            'wrapper' => [
                'class' => 'form-group col-md-4'
            ]
        ]);

        $this->crud->addField([
            "label" => 'Code',
            "name" => "code"
        ]);

        $this->crud->addField([
            "label" => 'Currency',
            "name" => "currency"
        ]);

        $this->crud->addField([
            "label" => 'Order',
            "name" => "order",
            'type' => 'number'
        ]);

        $this->addTranslatedField($this->crud, 'Name', 'name', 'text', config('backpack.crud.locales'));
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

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            "label" => 'ID',
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Name',
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => 'Code',
            "name" => "code"
        ]);

        $this->crud->addColumn([
            "label" => 'Currency',
            "name" => "currency"
        ]);

        $this->crud->addColumn([
            "label" => 'Order',
            "name" => "order"
        ]);

        $this->crud->addColumn([
            "label" => 'Status',
            "name" => "status",
            "type" => "enum",
            'options' => CommonStatusEnums::asArray()
        ]);
    }
}
