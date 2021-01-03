<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    //
    use CrudTrait;

    protected $fillable = [
            'name'
    ];

    protected $table = 'children';
}
