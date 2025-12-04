<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';
    
    protected $fillable = [
        'nama', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk kompatibilitas
    public function getIdAttribute()
    {
        return $this->id_user;
    }

    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'id_user', 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user', 'id_user');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_user', 'id_user');
    }
}
