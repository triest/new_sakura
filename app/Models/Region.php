<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //

    public function city(){
        return $this->hasMany(City::class,'city_id','id');
    }

}
