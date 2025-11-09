<?php

use Illuminate\Support\Facades\Broadcast;

// Private channel for all admins
Broadcast::channel('admin-channel', function ($user) {
    // Check if the currently authenticated user is an admin
    return $user->type->value === 'admin';
});