<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $message;
    private $channelId;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, int $channelId)
    {
        $this->message = $message;
        $this->channelId = $channelId;
    }

    /**
     * Get the channel the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('chat_' . $this->channelId);
    }

    public function broadcastAs(): string
    {
        return "store_message";
    }

    public function broadcastWith()
    {
        return
            [
                "message" => new MessageResource($this->message),
                'channel_id' => $this->channelId,
            ];
    }
}
