<?php

    namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use CrudTrait;

    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    //
    protected $table="interest";
}
