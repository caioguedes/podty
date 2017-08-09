<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class AnalyticsPageView
{
    use InteractsWithSockets, SerializesModels;
    
    public $path;
    public $title;
    
    /**
     * Create a new event instance.
     *
     * @param $path
     * @param $title
     */
    public function __construct($path, $title)
    {
        $this->path = $path;
        $this->title = $title;
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
