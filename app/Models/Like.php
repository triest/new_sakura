<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lk\User;

class Like extends Model
{
    //
    protected $table = "likes";


    public function who()
    {
        return $this->belongsTo(User::class, 'who_id', 'id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id', 'id');
    }
}
