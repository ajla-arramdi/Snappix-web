<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_foto_id',
        'content',
        'is_banned',
        'banned_at',
        'banned_by',
        'ban_reason',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    // Relasi ke user yang membuat komentar
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke postingan foto
    public function postFoto()
    {
        return $this->belongsTo(PostFoto::class, 'post_foto_id');
    }

    // Relasi ke admin/mod yang membanned komentar
    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }
}
