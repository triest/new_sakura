<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Lk\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');

        $this->crud->addColumns(['name', 'email', 'sex', 'age ']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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

        //   CRUD::setFromDb(); // fields

        $this->crud->addField(
                [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => "Имя"
                ]
        );

        $this->crud->addField(
                [
                        'name' => 'email',
                        'type' => 'email',
                        'label' => "email"
                ]
        );

        $this->crud->addField(
                [
                        'name' => 'phone',
                        'type' => 'text',
                        'label' => "телефон"
                ]
        );

        $this->crud->addField(
                [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => "Текст"
                ]
        );


        $this->crud->addField(
                [
                        'name' => 'private',
                        'type' => 'textarea',
                        'label' => "скрытый текст"
                ]
        );

        $this->crud->addField(
                [
                        'name' => 'sex',
                        'type' => 'select_from_array',
                        'options' => ['мужчина' => 'мужчина', 'женщина' => 'женщина', 'не указанно' => 'не указанно'],
                        'allows_null' => false,
                        'allows_multiple' => false,
                ]
        );


        $this->crud->addField(
                [
                        'label' => 'Цели',
                        'name' => 'target',
                        'entity' => 'target',
                        'type' => 'select2_multiple',
                        'attribute' => 'name',
                        'pivot' => true,
                        'model' => 'App\Models\Target',
                        'options' => (function ($query) {
                            return $query->orderBy('name', 'ASC')->get();
                        })
                ]
        );

        $this->crud->addField(
                [
                        'label' => 'Интересы',
                        'name' => 'interest',
                        'entity' => 'interest',
                        'type' => 'select2_multiple',
                        'attribute' => 'name',
                        'pivot' => true,
                        'model' => 'App\Models\Interest',
                        'options' => (function ($query) {
                            return $query->orderBy('name', 'ASC')->get();
                        })
                ]
        );

        $this->crud->addField(
                [
                        'label' => 'Отношения',
                        'name' => 'relation',
                        'entity' => 'relation',
                        'type' => 'select',
                        'attribute' => 'name',
                        'pivot' => false,
                        'model' => 'App\Models\Relation',
                        'options' => (function ($query) {
                            return $query->orderBy('name', 'ASC')->get();
                        })
                ]
        );



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
