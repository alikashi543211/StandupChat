<?php

namespace App\Events;

use App\Models\Channel AS ChannelModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private readonly Message $message;
    private readonly ChannelModel $channel;
    private readonly User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, ChannelModel $channel)
    {
        Log::info("Fine Working.........");
        $this->message = $message;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        $channelName = (string) 'channel-' . $this->channel->name;

        Log::info("Channel Name to Broadcast On => " . $channelName);

        return [
            new PrivateChannel($channelName),
        ];
    }

    public function broadcastWith(): array
    {

        $data['type'] = $this->message->attachments ? 'attachment' : 'text';
        $data['profile_image'] = $this->message->user->image;
        $data['message'] = $this->message->attachments ? url($this->message->attachments) : $this->message->message;

        return $data;

    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

}

