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

class NewEventRequest   implements ShouldBroadcastNow
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
      //  return new PrivateChannel('channel-name');
        $event=$this->eventRequest->event()->first();
        if(!$event){
            return null;
        }
        $user=$event->user()->first();

        if(!$user){
            return null;
        }
         return new PrivateChannel('user.' . $user->id);
    }

    public function broadcastWith()
    {
        $this->eventRequest->load('event')->load('user')->load('status');
        return ["eventRequest" => $this->eventRequest];
    }
}
