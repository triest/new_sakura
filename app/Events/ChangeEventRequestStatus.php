<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeEventRequestStatus   implements ShouldBroadcastNow
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventRequest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventRequest)
    {
        //
        $this->eventRequest=$eventRequest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $user=$this->eventRequest->user()->first();

        return new PrivateChannel('user.' . $user->id);
    }

    public function broadcastWith()
    {
        $this->eventRequest->load('user')->load('event')->load('status');
        return ["eventRequest" => $this->eventRequest];
    }
}
