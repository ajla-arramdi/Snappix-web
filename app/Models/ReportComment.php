<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'alasan',
        'deskripsi',
        'status',
        'admin_id',
        'admin_notes',
        'reviewed_at',
    ];

    // Relasi ke user pelapor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke komentar yang dilaporkan
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Relasi ke admin yang memproses
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
