<?php

namespace App;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{
    //
    protected $table = 'event_status';

    public function event()
    {
        return $this->belongsTo(Event::class, 'id', 'status_id');
    }
}
