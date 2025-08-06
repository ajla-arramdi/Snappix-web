<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_foto_id',
        'isi_komentar',
        'is_banned',
        'banned_at',
        'banned_by',
        'ban_reason',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postFoto()
    {
        return $this->belongsTo(PostFoto::class);
    }

    public function reportComments()
    {
        return $this->hasMany(ReportComment::class);
    }
}

