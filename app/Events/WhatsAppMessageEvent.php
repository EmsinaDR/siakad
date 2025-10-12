<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class WhatsAppMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return ['whatsapp-channel'];
    }

    public function broadcastAs()
    {
        return 'whatsapp-message';
    }
}
