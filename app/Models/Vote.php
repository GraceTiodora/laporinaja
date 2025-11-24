<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_vote';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_report',
        'type', // 'penting' atau 'tidak_penting'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_report', 'id_report');
    }
}

