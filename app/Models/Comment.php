<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comment';
    public $timestamps = true;

    protected $fillable = [
        'id_report',
        'id_user',
        'text',
        'likes',
    ];

    protected $casts = [
        'likes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_report', 'id_report');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
