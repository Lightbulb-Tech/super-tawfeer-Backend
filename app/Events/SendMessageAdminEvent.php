<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageAdminEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_object;
    public $receiver_id;

    public function __construct(Message $message)
    {
        $this->message_object = $message;
        $this->receiver_id = $message->receiver_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('send-message-channel.' . $this->message_object->receiver_id . '.' . $this->message_object->sender_id),
        ];
    }
    public function broadcastWith()
    {
        return [
            'sender_id' => $this->message_object->sender_id,
            'receiver_id' => $this->message_object->receiver_id,
            'text' => $this->message_object->text,
            'type' => $this->message_object->type,
            'file' => $this->message_object->file,
            'audio' => $this->message_object->audio,
            'time' => $this->message_object->created_at->diffForHumans(),
        ];
    }
}
