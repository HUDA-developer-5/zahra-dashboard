<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonStatusEnums;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Traits\HasTranslatedField;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
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
        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
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
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id', // the column that contains the ID of that connected entity;
            'entity' => 'parent', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => Category::class
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
        CRUD::setValidation(CategoryRequest::class);

        $this->crud->addField([
            'label' => 'Parent Category',
            'type' => 'relationship',
            'name' => 'parent',
            'model' => Category::class,
            'attribute' => 'name',
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
                'class' => 'form-group col-md-4'
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
