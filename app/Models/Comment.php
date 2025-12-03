<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comment';
    
    protected $fillable = [
        'id_report', 'id_user', 'isi', 'tanggal_comment', 'target_comment'
    ];

    protected $casts = [
        'tanggal_comment' => 'datetime',
    ];

    // Accessor untuk kompatibilitas
    public function getIdAttribute()
    {
        return $this->id_comment;
    }

    public function getContentAttribute()
    {
        return $this->isi;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_report', 'id_report');
    }
}
