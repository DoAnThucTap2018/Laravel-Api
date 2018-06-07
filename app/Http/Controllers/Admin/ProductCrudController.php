<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Input;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;

class ProductCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Item');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');
        $this->crud->orderBy('id','desc');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // ------ CRUD FIELDS
        $this->getFieldProduct();

        // ------ CRUD COLUMNS
        $this->getColumnProduct();
        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        $this->crud->setDetailsRowView('vendor.backpack.crud.details_row.products');
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
    /*
   |--------------------------------------------------------------------------
   | FUNCTION
   |--------------------------------------------------------------------------
   */
    private function getFieldProduct()
    {
        $this->getTabProduct();
        $this->getTabProductDetail();
    }
    private function getColumnProduct()
    {
        $this->crud->addColumn([
            'name'  => 'title', // The db column name
            'label' => "Title", // Table column heading
        ]);
        $this->crud->addColumn([
            'label'      => "Taxonomy Item",           // Table column heading
            'type'       => "select_multiple",
            'name'       => 'taxonomy_item',        // the column that contains the ID of that connected entity;
            'entity'     => 'taxonomy_item',           // the method that defines the relationship in your Model
            'attribute'  => 'name',
            'model'      => "App\Models\TaxonomyItem", // foreign key model
        ]);
        $this->crud->addColumn([
            'label'      => "Item type",
            'type'       => 'select',
            'name'       => 'item_type_id',         // the db column for the foreign key
            'entity'     => 'item_type',            // the method that defines the relationship in your Model
            'attribute'  => 'name',                 // foreign key attribute that is shown to user
            'model'      => "App\Models\ItemType",  // foreign key model
        ]);
        $this->crud->addColumn([
            'label'      => "Price",              // Table column heading
            'type'       => "select",
            'name'       => 'price',              // the column that contains the ID of that connected entity;
            'entity'     => 'product',            // the method that defines the relationship in your Model
            'attribute'  => "price",              // foreign key attribute that is shown to user
            'model'      => "App\Models\Product", // foreign key model
        ]);
        $this->crud->addColumn([
            'label'     => "Unit",               // Table column heading
            'type'      => "select",
            'name'      => 'unit_id',           // the column that contains the ID of that connected entity;
            'entity'    => 'unit',              // the method that defines the relationship in your Model
            'attribute' => "name",              // foreign key attribute that is shown to user
            'model'     => "App\Models\Unit",   // foreign key model
        ]);
    }
    /*
   |--------------------------------------------------------------------------
   | CHILD FUNCION
   |--------------------------------------------------------------------------
   */
    private function getTabProduct()
    {
        $this->crud->addField([
            'name'  => 'title',
            'label' => 'Title',
            'type'  => 'text',
            'tab'   => 'Product',
        ]);
        $this->crud->addField([
            'label'         => 'Taxonomy Item',
            'type'          => 'select2_multiple',
            'name'          => 'taxonomy_item',            // the method that defines the relationship in your Model
            'entity'        => 'taxonomy_item',            // the method that defines the relationship in your Model
            'attribute'     => 'name',                     // foreign key attribute that is shown to user
            'model'         => "App\Models\TaxonomyItem",  // foreign key model
            'pivot'         => true,                       // on create&update, do you need to add/delete pivot table entries?
            'select_all'    => true,                       // show Select All and Clear buttons?
            'tab'           => 'Product',
        ]);
        $this->crud->addField([
            // SELECT
            'label'         => 'Price',
            'type'          => 'number',
            'name'          => 'price',
            'key'           => 'product.price',
            'entity'        => 'product',
            'attribute'     => 'price',
            'prefix'        => '$',
            'tab'           => 'Product',
        ]);
        $this->crud->addField([
            'label'         => "Unit",
            'type'          => 'select2',
            'name'          => 'unit_id',         // the db column for the foreign key
            'entity'        => 'unit',            // the method that defines the relationship in your Model
            'attribute'     => 'name',            // foreign key attribute that is shown to user
            'model'         => "App\Models\Unit", // foreign key model
            'tab'           => 'Product',
        ]);
        $this->crud->addField([
            'label'         => "Promotion",
            'type'          => 'select2_multiple',
            'name'          => 'promotion',            // the method that defines the relationship in your Model
            'entity'        => 'promotion',            // the method that defines the relationship in your Model
            'attribute'     => 'name',                 // foreign key attribute that is shown to user
            'model'         => "App\Models\Promotion", // foreign key model
            'pivot'         => true,                   // on create&update, do you need to add/delete pivot table entries?
            'select_all'    => true,                   // show Select All and Clear buttons?
            'tab'           => 'Product',
        ]);
        $this->crud->addField([
            'label'         => "Image",
            'name'          => "image",
            'type'          => 'image',
            'upload'        => true,
            'crop'          => true,      // set to true to allow cropping, false to disable
            'aspect_ratio'  => 0,         // commit or set to 0 to allow any aspect ratio
           // 'disk' => 'uploads',        // in case you need to show images from a different disk
            'prefix'        => 'images/', // in case you only store the filename in the database, this text will be prepended to the database value
            'default'       => 'default/picture.jpg',
            'key'           => 'product.image',
            'entity'        => 'product',
            'attribute'     => 'image',
            'default'       => 'default/picture.png',
            'tab'           => 'Product',
        ]);
    }
    private function getTabProductDetail()
    {
        $this->crud->addField([
            'label'             => "Item type",
            'type'              => 'select2',
            'name'              => 'item_type_id',        // the db column for the foreign key
            'entity'            => 'item_type',           // the method that defines the relationship in your Model
            'attribute'         => 'name',                // foreign key attribute that is shown to user
            'model'             => "App\Models\ItemType", // foreign key model
            'wrapperAttributes' => [
                'class'         => 'form-group col-md-6'
            ],
            'tab'               => 'Product detail',
        ]);
        $this->crud->addField([
            'name'  => 'summary',
            'label' => 'Summary',
            'type'  => 'summernote',
            'tab'   => 'Product detail',
        ]);
//        $this->crud->addField([
//            'name'      => 'attributes',
//            'label'     => 'Attribute',
//            'type'      => 'summernote',
//            'key'       => 'product.attributes',
//            'entity'    => 'product',
//            'attribute' => 'attributes',
//            'tab'       => 'Product detail',
//        ]);
        $this->crud->addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'summernote',
            'tab'   => 'Product detail',
        ]);
//        $this->crud->addField([
//            'name'      => 'additional_information',
//            'label'     => 'Additional Information',
//            'key'       => 'product.additional_information',
//            'entity'    => 'product',
//            'type'      => 'summernote',
//            'tab'       => 'Product detail',
//        ]);
    }

}
