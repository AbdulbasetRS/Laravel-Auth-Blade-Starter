<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'kinship',
        'whatapp_number',
        'telegram_number',
        'date_of_birth',
        'gender',
        'avatar',
        'title',
        'address',
        'note',
    ];

    protected $casts = [
        'date_of_birth' => 'datetime',
    ];

    protected $hidden = [

    ];

    function getRouteKeyName()
    {
        return 'id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}