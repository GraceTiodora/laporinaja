<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'bio', 'phone', 'address', 'reputation'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_user');
    }
}
