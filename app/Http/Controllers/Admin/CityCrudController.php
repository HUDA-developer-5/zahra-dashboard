<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonStatusEnums;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use App\Models\Nationality;
use App\Models\State;
use App\Traits\HasTranslatedField;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CityCrudController extends CrudController
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
        CRUD::setModel(City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/city');
        CRUD::setEntityNameStrings('city', 'cities');
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
            'label' => 'Nationality',
            'type' => 'relationship',
            'name' => 'nationality_id',
            'entity' => 'nationality',
            'model' => Nationality::class,
            'attribute' => 'name',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('nationality/' . $related_key . '/show');
                },
                'target' => '_blank'
            ],
        ]);

        $this->crud->addColumn([
            'label' => 'State',
            'type' => 'relationship',
            'name' => 'state_id',
            'entity' => 'state',
            'model' => State::class,
            'attribute' => 'name',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('state/' . $related_key . '/show');
                },
                'target' => '_blank'
            ],
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
        CRUD::setValidation(CityRequest::class);
        $this->crud->addField([
            'label' => 'Nationality',
            'type' => 'relationship',
            'name' => 'nationality',
            'model' => Nationality::class,
            'attribute' => 'name',
        ]);

        $this->crud->addField([
            'label' => 'State',
            'type' => 'relationship',
            'name' => 'state',
            'model' => State::class,
            'attribute' => 'name',
        ]);

        $this->crud->addField([
            "name" => "status",
            "label" => 'Status',
            'type' => 'enum',
            "options" => CommonStatusEnums::asArray(),
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
}
