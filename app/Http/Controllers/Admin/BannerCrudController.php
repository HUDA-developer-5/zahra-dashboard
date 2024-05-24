<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonStatusEnums;
use App\Http\Requests\Admin\BannerRequest;
use App\Traits\HasTranslatedField;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BannerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BannerCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Banner::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/banner');
        CRUD::setEntityNameStrings('banner', 'banners');
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
            "label" => 'Title',
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => 'Start Date',
            "name" => "start_date",
            'type' => 'date',
        ]);

        $this->crud->addColumn([
            "label" => 'End Date',
            "name" => "end_date",
            'type' => 'date',
        ]);

        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'disk' => config("filesystems.default"),
            'height' => '30px',
            'width' => '30px',
            'limit' => 500
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
        CRUD::setValidation(BannerRequest::class);
        $this->crud->addField([
            "name" => "start_date",
            "label" => 'Start Date',
            'type' => 'date_picker',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "end_date",
            "label" => 'End Date',
            'type' => 'date_picker',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "status",
            "label" => 'Status',
            'type' => 'enum',
            "options" => CommonStatusEnums::asArray(),
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'disk' => config("filesystems.default"),
            'type' => 'upload',
            'upload' => true,
            'hint' => 'You can upload 1 image | jpeg,png,jpg,gif,svg | max 5M',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "link",
            "label" => 'Link',
            'type' => 'url',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->addTranslatedField($this->crud, 'Title', 'name', 'text', config('backpack.crud.locales'));
        $this->addTranslatedField($this->crud, 'Description', 'description', 'textarea', config('backpack.crud.locales'));
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
