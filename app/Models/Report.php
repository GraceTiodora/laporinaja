<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'judul', 'deskripsi', 'lokasi', 'foto', 'status',
        'id_user', 'id_category', 'id_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_report');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_report');
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class, 'id_report');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}

