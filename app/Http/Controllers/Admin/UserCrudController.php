<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;

class UserCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('user', 'users');
        $this->getFieldUser();

        // ------ CRUD COLUMNS
        $this->getColumnUser();
        // ------ CRUD DETAILS ROW

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
    }
        public function store(StoreRequest $request)
        {
            // your additional operations before save here
            $redirect_location = parent::storeCrud($request);
            // your additional operations after save here
            // use $this->data['entry'] or $this->crud->entry
            return $redirect_location;
        }

        public function update(UpdateRequest $request)
        {
            // your additional operations before save here
            $redirect_location = parent::updateCrud($request);
            // your additional operations after save here
            // use $this->data['entry'] or $this->crud->entry
            return $redirect_location;
        }



    private function getFieldUser()
    {
        $this->getTabUser();

    }

    private function getTabUser()
    {
        // ------ CRUD FIELDS
        $this->crud->addField([
            'label' => "First Name",
            'type'  => 'text',
            'name'  => 'first_name',

        ]);
        $this->crud->addField([
            'label'  => "Last Name",
            'type'   => 'text',
            'name'   => 'last_name',

        ]);
        $this->crud->addField([
            'label'  => "Email",
            'type'   => 'email',
            'name'   => 'email',

        ]);
        $this->crud->addField([
            'label'  => "Mobile",
            'type'   => 'text',
            'name'   => 'mobile',

        ]);
        $this->crud->addField([
            'label'  => "Password",
            'type'   => 'password',
            'name'   => 'password',

        ]);
        $this->crud->addField([
            'label'   => "Retype Password",
            'type'    => 'password',
            'name'    => 'remember_token',

        ]);
        $this->crud->addField([
            'label'     => "Role",
            'type'      => 'select2',
            'name'      => 'role_id',         // the db column for the foreign key
            'entity'    => 'role',            // the method that defines the relationship in your Model
            'attribute' => 'name',            // foreign key attribute that is shown to user
            'model'     => "App\Models\Role",  // foreign key model

        ]);
        $this->crud->addField([
            'label'        => "Image",
            'name'         => "image",
            'type'         => 'image',
            'upload'       => true,
            'crop'         => true,       // set to true to allow cropping, false to disable
            'aspect_ratio' => 0,          // ommit or set to 0 to allow any aspect ratio
            'prefix'       => 'images/',  // in case you only store the filename in the database, this text will be prepended to the database value
            'default'      => 'default/picture.png',

        ]);
    }




    private function getColumnUser()
    {
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name'   => 'first_name',
            'label'  => 'Firt Name ',
        ]);
        $this->crud->addColumn([
            'name'   => 'last_name',
            'label'  => 'Last Name ',
        ]);
        $this->crud->addColumn([
            'name'   => 'email',
            'label'  => 'Email',
        ]);
        $this->crud->addColumn([
            'label'     => "Role",
            'type'      => 'select',
            'name'      => 'role_id',
            'entity'    => 'role',
            'attribute' => 'name',
            'model'     => "App\Models\Role"
        ]);
        // Check (Encrypt or Skip) the Password
        if (Input::filled('password')) {
            Input::merge(['password' => bcrypt(Input::get('password'))]);
        } else {
            Input::replace(Input::except(['password']));
        }
    }
}


