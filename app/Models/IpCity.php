<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpCity extends Model
{
    //
    protected $table="ips";

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
