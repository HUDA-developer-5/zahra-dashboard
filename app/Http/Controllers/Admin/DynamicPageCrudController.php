<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StaticPagesEnums;
use App\Http\Requests\Admin\DynamicPageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DynamicPageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DynamicPageCrudController extends CrudController
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
        CRUD::setModel(\App\Models\DynamicPage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dynamic-page');
        CRUD::setEntityNameStrings('dynamic page', 'dynamic pages');
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
            "label" => 'Page',
            "name" => "slug"
        ]);

        $this->crud->addColumn([
            "label" => 'Title Arabic',
            "name" => "title_ar"
        ]);

        $this->crud->addColumn([
            "label" => 'Title English',
            "name" => "title_en"
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
        CRUD::setValidation(DynamicPageRequest::class);

        $this->crud->addField([
            "label" => 'Slug',
            "name" => "slug",
            "type" => "enum",
            "options" => StaticPagesEnums::asArray()
        ]);

        $this->crud->addField([
            "label" => 'Title Arabic',
            "name" => "title_ar"
        ]);

        $this->crud->addField([
            "label" => 'Title English',
            "name" => "title_en"
        ]);

        $this->crud->addField([
            "label" => 'Content Arabic',
            "name" => "content_ar",
            "type" => "summernote",
        ]);

        $this->crud->addField([
            "label" => 'Content English',
            "name" => "content_en",
            "type" => "summernote",
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

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            "label" => 'ID',
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Page',
            "name" => "slug"
        ]);

        $this->crud->addColumn([
            "label" => 'Title Arabic',
            "name" => "title_ar"
        ]);

        $this->crud->addColumn([
            "label" => 'Title English',
            "name" => "title_en"
        ]);

        $this->crud->addColumn([
            "label" => 'Content Arabic',
            "name" => "content_ar",
            "type" => "summernote",
        ]);

        $this->crud->addColumn([
            "label" => 'Content English',
            "name" => "content_en",
            "type" => "summernote",
        ]);
    }
}
