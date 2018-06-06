<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SettingRequest as StoreRequest;
use App\Http\Requests\SettingRequest as UpdateRequest;

class SettingCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel('App\Models\Setting');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/setting');
        $this->crud->setEntityNameStrings('setting', 'settings');
        $this->crud->denyAccess(['create', 'delete']);
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Name',
            ],
            [
                'name'  => 'value',
                'label' => 'Value',
            ],
            [
                'name'  => 'description',
                'label' => 'Description',
            ],
        ]);
        $this->crud->addField([
            'name'   => 'name',
            'label'  => 'Name',
            'type'   => 'text',
            'attributes'   => [
                'disabled' => 'disabled',
            ],
        ]);

    }
    /**
     * Display all rows in the database for this entity.
     * This overwrites the default CrudController behaviour:
     * - instead of showing all entries, only show the "active" ones.
     *
     * @return Response
     */
    public function index()
    {
        $this->crud->addClause('where', 'active', 1);

        return parent::index();
    }
    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    /**
     * @param int $id
     * @return \Backpack\CRUD\app\Http\Controllers\Response|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Backpack\CRUD\Exception\AccessDeniedException
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->crud->addField((array) json_decode($this->data['entry']->field)); // <---- this is where it's different
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
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
