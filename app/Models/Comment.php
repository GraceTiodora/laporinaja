<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'isi', 'tanggal_comment', 'id_user', 'id_report'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_report');
    }
}
