<?php

namespace App\Observers;

use App\Events\NewUserRegistered;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user)
    {
        $user->slug = Str::slug($user->username).'-'.Str::random(6);
        $user->created_by = Auth::id();
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // $userResource = new UserResource($user);
        // event(new \App\Events\NewUserRegistered($userResource));

        // أرسل الـ database notification لكل الـ admins
        $admins = User::where('type', 'admin')
            ->where('status', 'active')
            ->where('can_login', true)
            ->get();
        Notification::send($admins, new NewUserRegisteredNotification($user));

        $userResource = new UserResource($user);
        broadcast(new NewUserRegistered($userResource))->toOthers();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
