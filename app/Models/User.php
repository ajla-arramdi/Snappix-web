<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_banned',
        'banned_at',
        'banned_by',
        'ban_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'banned_at' => 'datetime',
        'is_banned' => 'boolean',
    ];

    public function postFotos()
    {
        return $this->hasMany(PostFoto::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function komentarFotos()
    {
        return $this->hasMany(KomentarFoto::class);
    }

    public function likeFotos()
    {
        return $this->hasMany(LikeFoto::class);
    }


    public function reportPosts()
    {
        return $this->hasMany(ReportPost::class);
    }

    public function reportComments()
    {
        return $this->hasMany(ReportComment::class);
    }
}

