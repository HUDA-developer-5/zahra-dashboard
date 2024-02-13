<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\UserStatusEnums;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Nationality;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
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
        ], UserStatusEnums::asArray()
            , function ($value) {
                $this->crud->addClause('where', 'status', $value);
            });

        $this->crud->addColumn([
            "label" => '#',
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
            "label" => 'Whatsapp Number',
            "name" => "whatsapp_number",
            "type" => "phone"
        ]);

        $this->crud->addColumn([
            "label" => 'Status',
            "name" => "status",
            "type" => "enum",
            'options' => UserStatusEnums::asArray()
        ]);

        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'disk' => config("filesystems.default"),
            'height' => '30px',
            'width' => '30px',
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
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);
        $this->addFields();
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
            "name" => "name",
            "type" => "text",
            "label" => 'Name',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "email",
            "type" => "email",
            "label" => 'Email',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "status",
            "label" => 'Status',
            'type' => 'enum',
            "options" => UserStatusEnums::asArray(),
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "password",
            "type" => "password",
            "label" => 'Password',
            'hint' => 'Let password empty if you don\'t need to change',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            'name' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'type' => 'password',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "phone_number",
            "type" => "text",
            "label" => 'Phone Number',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            "name" => "whatsapp_number",
            "type" => "text",
            "label" => 'Whatsapp Number',
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
            'label' => 'Nationality',
            'type' => 'relationship',
            'name' => 'nationality',
            'model' => Nationality::class,
            'attribute' => 'name',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

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
            'options' => UserStatusEnums::asArray()
        ]);

        $this->crud->addColumn([
            "name" => "whatsapp_number",
            "type" => "text",
            "label" => 'Whatsapp Number',
        ]);

        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'disk' => config("filesystems.default"),
            'height' => '30px',
            'width' => '30px',
        ]);

        $this->crud->addColumn([
            'label' => 'Nationality',
            'type' => 'relationship',
            'name' => 'nationality',
            'model' => Nationality::class,
            'attribute' => 'name',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('nationality/'.$related_key.'/show');
                },
                'target' => '_blank',
            ],
        ]);
    }
}
