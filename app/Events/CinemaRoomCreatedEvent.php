<?php

namespace App\Events;

use App\Models\CinemaRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CinemaRoomCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $cinemaRoom;

    /**
     * Create a new event instance.
     */
    public function __construct(CinemaRoom $cinemaRoom)
    {
        $this->cinemaRoom = $cinemaRoom;
    
}
}