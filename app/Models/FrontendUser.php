<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontendUser extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'frontend_users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'password',
        'profile_picture',
        'email_verified_at',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];
}
