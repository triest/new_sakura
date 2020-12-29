<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    //
    protected $table="relation";

    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne(\App\Models\Lk\User::class);
    }
}
