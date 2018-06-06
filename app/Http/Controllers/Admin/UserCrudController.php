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
        $this->getTabIdentification();
    }

    private function getTabUser()
    {
        // ------ CRUD FIELDS
        $this->crud->addField([
            'label' => "First Name",
            'type'  => 'text',
            'name'  => 'first_name',
            'tab'   => 'User',
        ]);
        $this->crud->addField([
            'label'  => "Last Name",
            'type'   => 'text',
            'name'   => 'last_name',
            'tab'    => 'User',
        ]);
        $this->crud->addField([
            'label'  => "Email",
            'type'   => 'email',
            'name'   => 'email',
            'tab'    => 'User',
        ]);
        $this->crud->addField([
            'label'  => "Mobile",
            'type'   => 'text',
            'name'   => 'mobile',
            'tab'    => 'User',
        ]);
        $this->crud->addField([
            'label'  => "Password",
            'type'   => 'password',
            'name'   => 'password',
            'tab'    => 'User',
        ]);
        $this->crud->addField([
            'label'   => "Retype Password",
            'type'    => 'password',
            'name'    => 'remember_token',
            'tab'     => 'User',
        ]);
        $this->crud->addField([
            'label'     => "Role",
            'type'      => 'select2',
            'name'      => 'role_id',         // the db column for the foreign key
            'entity'    => 'role',            // the method that defines the relationship in your Model
            'attribute' => 'name',            // foreign key attribute that is shown to user
            'model'     => "App\Models\Role",  // foreign key model
             'tab'      => 'User',
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
            'tab'          => 'User',
        ]);
    }
    private function getTabIdentification()
    {
        $this->crud->addField([  // Select2
            'label'     => "Estimated Monthly Consumption",
            'type'      => 'text',
            'name'      => 'estimated_consumption',
            'tab'       => 'Identification',
        ]);
        $this->crud->addField([
            'label' => 'Referral Number',
            'name'  => 'referral_number',
            'type'  => 'text',
            'tab'   => 'Identification',
        ]);
        $this->crud->addField([
            'name'      => 'identification_type',
            'label'     => 'Type Indentifition',
            'type'      => 'radio',
            'options'   => [ // the key will be stored in the db, the value will be shown as label;
                1       => "Passport",
                2       => "Driving Lice",
                3       => "Nie"
            ],
            'inline'    => true,
            'tab'       => 'Identification',
        ]);
        $this->crud->addField([
            'name'      => 'identification_number',
            'label'     => 'Identification Number',
            'type'      => 'text',
            'tab'       => 'Identification',
        ]);
        $this->crud->addField([
            'label'        => "Image Identification",
            'name'         => "identification_image",
            'type'         => 'image',
            'upload'       => true,
            'crop'         => true,       // set to true to allow cropping, false to disable
            'aspect_ratio' => 0,          // ommit or set to 0 to allow any aspect ratio
            'prefix'       => 'images/',  // in case you only store the filename in the database, this text will be prepended to the database value
            'default'      => 'default/picture.png',
            'tab'          => 'Identification',
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


