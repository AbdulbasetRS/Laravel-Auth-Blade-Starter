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
            'title' => 'مستخدم جديد تم تسجيله 👤',
            'body' => 'المستخدم '.$this->user->username.' انضم للنظام.',
            'user_id' => $this->user->id,
        ];
    }

    public function broadcastWhen(): bool
    {
        return config('services.notifications_enabled');
    }

    // // البيانات اللي تتبعت على الـ Pusher (Real-time)
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'user' => [
    //             'title' => 'مستخدم جديد تم تسجيله 👤',
    //             'body' => 'المستخدم '.$this->user->username.' انضم للنظام.',
    //             'user_id' => $this->user->id,
    //             'created_by' => $this->user->created_by,
    //             'username' => $this->user->username,
    //             'slug' => $this->user->slug,
    //         ],
    //     ]);
    // }

    // // اسم القناة اللي هيتم البث عليها
    // public function broadcastOn()
    // {
    //     return ['admins-channel']; // نفس القناة اللى كنت بتستخدمها
    // }

    // public function broadcastAs()
    // {
    //     return 'new-user-registered';
    // }
}
