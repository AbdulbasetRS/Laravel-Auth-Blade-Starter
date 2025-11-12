<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    // تحديد الـ channels المستخدمة
    public function via($notifiable)
    {
        return ['database'];
    }

    // البيانات اللي تتخزن في قاعدة البيانات
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'مستخدم جديد تم تسجيله',
            'body' => 'المستخدم '.$this->user->username.' انضم للنظام.',
            'user_id' => $this->user->id,
            'slug' => $this->user->slug,
        ];
    }

    public function broadcastWhen(): bool
    {
        return config('services.notifications_enabled');
    }
}
