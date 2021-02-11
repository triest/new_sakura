<?php

namespace App;

use App\Models\EventRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lk\User;

class EventRequestStatus extends Model
{
    //
    protected $table="event_request_status";

    public function eventRequest(){
        return $this->belongsTo(EventRequest::class);
    }
}
