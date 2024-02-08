<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminRolesEnums;
use App\Enums\AdminStatusEnums;
use App\Enums\AdminTypesEnums;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
//        dd(backpack_user()->isAdmin());
        CRUD::setModel(Admin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin');
        CRUD::setEntityNameStrings('admin', 'admins');
        $this->crud->query->where('type', '=', AdminTypesEnums::Admin->value);
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
            'name' => 'role',
            'type' => 'dropdown',
            'label' => 'Role',
        ], AdminRolesEnums::asArray()
            , function ($value) {
                $this->crud->addClause('where', 'role', $value);
            });

        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Status',
        ], AdminStatusEnums::asArray()
            , function ($value) {
                $this->crud->addClause('where', 'status', $value);
            });


        $this->crud->addColumn([
            "label" => "ID",
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Name',
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => 'Email',
            "name" => "email",
            '"type' => "email"
        ]);

        $this->crud->addColumn([
            "label" => 'Phone Number',
            "name" => "phone_number",
            "type" => "phone"
        ]);

        $this->crud->addColumn([
            "label" => 'Status',
            "name" => "status",
            "type" => "enum",
            'options' => AdminStatusEnums::asArray()
        ]);

        $this->crud->addColumn([
            "label" => 'Role',
            "name" => "role",
            "type" => "enum",
            'options' => AdminRolesEnums::asArray()
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
        $this->addFields();
        $this->crud->setValidation(CreateAdminRequest::class);
    }

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
        return $this->traitStore();
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(UpdateAdminRequest::class);
    }

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
        return $this->traitUpdate();
    }

    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }
        return $request;
    }

    protected function addFields()
    {
        $this->crud->addField([
            "name" => "type",
            "type" => "hidden",
            "value" => AdminTypesEnums::Admin->value,
        ]);

        $this->crud->addField([
            "name" => "name",
            "type" => "text",
            "label" => 'Name',
        ]);

        $this->crud->addField([
            "name" => "email",
            "type" => "email",
            "label" => 'Email',
        ]);

        $this->crud->addField([
            "name" => "password",
            "type" => "password",
            "label" => 'Password',
            'hint' => 'Let password empty if you don\'t need to change'
        ]);

        $this->crud->addField([
            'name' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'type' => 'password'
        ]);

        $this->crud->addField([
            "name" => "status",
            "label" => 'Status',
            'type' => 'enum',
            "options" => AdminStatusEnums::asArray()
        ]);

        $this->crud->addField([
            "name" => "role",
            "label" => 'Role',
            'type' => 'enum',
            "options" => AdminRolesEnums::asArray()
        ]);

        $this->crud->addField([
            "name" => "phone_number",
            "type" => "text",
            "label" => 'Phone Number'
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            "label" => "ID",
            "name" => "id"
        ]);

        $this->crud->addColumn([
            "label" => 'Name',
            "name" => "name"
        ]);

        $this->crud->addColumn([
            "label" => 'Email',
            "name" => "email",
            '"type' => "email"
        ]);

        $this->crud->addColumn([
            "label" => 'Phone Number',
            "name" => "phone_number",
            "type" => "phone"
        ]);

        $this->crud->addColumn([
            "label" => 'Status',
            "name" => "status",
            "type" => "enum",
            'options' => AdminStatusEnums::asArray()
        ]);

        $this->crud->addColumn([
            "label" => 'Roel',
            "name" => "role",
            "type" => "enum",
            'options' => AdminRolesEnums::asArray()
        ]);
    }
}
