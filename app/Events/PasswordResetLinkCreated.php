<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetLinkCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $resetUrl,
        protected string $channelToken,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("private-reset.{$this->channelToken}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'resetUrl' => $this->resetUrl,
        ];
    }
}
