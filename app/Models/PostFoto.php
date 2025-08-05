<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'image',
        'is_banned',
        'banned_at',
        'banned_by',
        'ban_reason',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function isLikedBy($userId)
    {
        return $this->likeFotos()->where('user_id', $userId)->exists();
    }

    public function likesCount()
    {
        return $this->likeFotos()->count();
    }
}


