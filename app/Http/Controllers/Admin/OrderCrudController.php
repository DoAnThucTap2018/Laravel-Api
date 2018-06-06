<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OrderRequest as StoreRequest;
use App\Http\Requests\OrderRequest as UpdateRequest;

class OrderCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('order', 'orders');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // ------ CRUD ACCESS
        $this->crud->denyAccess(['create']);
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name'  => 'id',
            'label' => 'Id Order ',
        ]);
        $this->crud->addColumn([
            'name'          => "user_id",
            'label'         => "Full name",
            'type'          => "model_function",
            'function_name' => 'getUserId',
        ]);
        $this->crud->addColumn([
            'label'      => 'Order Addresses',
            'type'       => 'select',
            'name'       => 'order_address_id',
            'entity'     => 'order_address',
            'attribute'  => 'name',
            'model'      => "App\Models\OrderAddress"

        ]);
        $this->crud->addColumn([
            'label' => 'Total Price',
            'name'       => 'order_id',
            'type'     => 'model_function',
            'function_name' => 'getTotalPrice',
        ]);
        $this->crud->addColumn([
            'label'     => "Status",
            'type'      => 'select',
            'name'      => 'order_status_id',         // the db column for the foreign key
            'entity'    => 'order_status',            // the method that defines the relationship in your Model
            'attribute' => 'name',                    // foreign key attribute that is shown to user
            'model'     => "App\Models\OrderStatus",  // foreign key model
        ]);
        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Date ',
            'type'  => 'date',
        ]);
        $this->crud->removeButton( 'update');
        $this->crud->addButtonFromModelFunction(
            'line', 'edit', 'edit', 'beginning'
        );
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
