<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class KomentarFoto extends Model
{
    use HasFactory;

    protected $table = 'komentar_fotos';

    protected $fillable = [
        'user_id',
        'post_foto_id',
        'isi_komentar',
        'is_banned',
        'banned_at',
        'banned_by',
        'ban_reason'
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postFoto()
    {
        return $this->belongsTo(PostFoto::class, 'post_foto_id');
    }

    public function reportComments()
    {
        return $this->hasMany(ReportComment::class, 'komentar_foto_id');
    }

    public function scopeNotBanned($query)
    {
        return $query->where('is_banned', false);
    }
}



