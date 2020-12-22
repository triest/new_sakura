<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    //
    protected $table="relation";


    public function user(){
        return $this->hasOne(\App\Models\Lk\User::class);
    }
}
