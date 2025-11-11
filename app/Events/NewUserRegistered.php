<?php

namespace App\Events;

use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewUserRegistered implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User|UserResource $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): array|Channel
    {
        return new Channel('admins-channel');
    }

    public function broadcastAs(): string
    {
        return 'new-user-registered';
    }

    public function broadcastWhen(): bool
    {
        return config('broadcasting.enabled')
        && config('broadcasting.connections.pusher.enabled')
        && config('services.notifications_enabled');
    }
}
