<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = [
        'deskripsi', 'id_admin', 'id_report'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_report');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
