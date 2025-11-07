<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'slug',
        'email',
        'mobile_number',
        'national_id',
        'nationality',
        'password',
        'status',
        'type',
        'can_login',
        'status_details',
        'role_id',
        'fcm_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatus::class,
        'type' => UserType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [
        'profile',
    ];

    function getRouteKeyName()
    {
        return 'slug';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function authProviders()
    {
        return $this->hasMany(AuthProvider::class, 'user_id', 'id');
    }

    public function userSettings()
    {
        return $this->hasOne(UserSettings::class, 'user_id', 'id');
    }

    public function hasTwoFactorEnabled(): bool
    {
        return $this->userSettings
            && $this->userSettings->enable_two_factor
            && !empty($this->userSettings->google2fa_secret);
    }

}
