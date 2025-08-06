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
        return $this->hasMany(KomentarFoto::class);
    }

    public function likeFotos()
    {
        return $this->hasMany(LikeFoto::class);
    }
}


