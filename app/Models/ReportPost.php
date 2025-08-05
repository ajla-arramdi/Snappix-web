<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_foto_id',
        'alasan',
        'deskripsi',
        'status',
        'admin_id',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postFoto()
    {
        return $this->belongsTo(PostFoto::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}