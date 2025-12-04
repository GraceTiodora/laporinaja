<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama kolom di database
    protected $primaryKey = 'id_report';
    
    protected $fillable = [
        'id_user', 'id_category', 'judul', 'deskripsi', 'lokasi', 'foto', 'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk kompatibilitas dengan kode yang menggunakan nama kolom bahasa Inggris
    public function getIdAttribute()
    {
        return $this->id_report;
    }

    public function getUserIdAttribute()
    {
        return $this->id_user;
    }

    public function getCategoryIdAttribute()
    {
        return $this->id_category;
    }

    public function getTitleAttribute()
    {
        return $this->judul;
    }

    public function getDescriptionAttribute()
    {
        return $this->deskripsi;
    }

    public function getLocationAttribute()
    {
        return $this->lokasi;
    }

    public function getImageAttribute()
    {
        return $this->foto;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_report', 'id_report');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class, 'id_report', 'id_report');
    }
}

