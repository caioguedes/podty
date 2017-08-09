<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class AnalyticsEvent
{
    use InteractsWithSockets, SerializesModels;
    
    public $category;
    public $action;
    
    /**
     * Create a new event instance.
     *
     * @param $category
     * @param $action
     */
    public function __construct($category, $action)
    {
        $this->category = $category;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
