<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TaxonomyItemRequest as StoreRequest;
use App\Http\Requests\TaxonomyItemRequest as UpdateRequest;

class TaxonomyItemCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\TaxonomyItem');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/taxonomyitem');
        $this->crud->setEntityNameStrings('taxonomyitem', 'taxonomy_items');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        /*
               |--------------------------------------------------------------------------
               | BASIC CRUD INFORMATION
               |--------------------------------------------------------------------------
               */
        $this->crud->setModel('App\Models\TaxonomyItem');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/taxonomy_item');
        $this->crud->setEntityNameStrings('taxonomy_item', 'taxonomy_items');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 2);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'label'     => 'Parent',
            'type'      => 'select',
            'name'      => 'parent_id',
            'entity'    => 'parent',
            'attribute' => 'name',
            'model'     => "App\Models\TaxonomyItem",
        ]);
        $this->crud->addField([
            'label'     => "Taxonomy",
            'type'      => 'select2',
            'name'      => 'taxonomy_id',         // the db column for the foreign key
            'entity'    => 'taxonomy',            // the method that defines the relationship in your Model
            'attribute' => 'name',                // foreign key attribute that is shown to user
            'model'     => "App\Models\Taxonomy"  // foreign key model

        ]);
        $this->crud->addField([
            'label'     => "Name",
            'type'      => 'text',
            'name'      => 'name',
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug',
            'type'  => 'text',
            'hint'  => 'Will be automatically generated from your title, if left empty.',
        ]);
        $this->crud->addField([ // image
            'label'         => "Image",
            'name'          => "image",
            'type'          => 'image',
            'upload'        => true,
            'crop'          => true, // set to true to allow cropping, false to disable
            'aspect_ratio'  => 0, // ommit or set to 0 to allow any aspect ratio
//             'disk' => 'uploads', // in case you need to show images from a different disk
            'prefix'        => 'images/', // in case you only store the filename in the database, this text will be prepended to the database value
            'default'       => 'default/picture.png',
        ]);
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'label'     => 'Parent',
            'type'      => 'select',
            'name'      => 'parent_id',
            'entity'    => 'parent',
            'attribute' => 'name',
            'model'     => "App\Models\TaxonomyItem",
        ]);
        $this->crud->addColumn([
            'name'      => 'taxonomy_id',
            'label'     => 'Taxonomy ',
        ]);
        $this->crud->addColumn([
            'name'      => 'name',
            'label'     => 'Name',
        ]);
        $this->crud->addColumn([
            'name'      => 'slug',
            'label'     => 'Slug',
        ]);
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
}
