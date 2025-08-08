<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostFoto extends Model
{
    protected $fillable = [
        'user_id', 'album_id', 'caption', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function komentarFotos()
    {
        return $this->hasMany(KomentarFoto::class, 'post_foto_id');
    }

    public function likeFotos()
    {
        return $this->hasMany(LikeFoto::class);
    }

    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likeFotos()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likeFotos()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->komentarFotos()->where('is_banned', false)->count();
    }

    public function scopeNotBanned($query)
    {
        return $query->where('is_banned', false);
    }
}



