<?php

namespace App\Models;

class User extends Authenticatable
{
    protected $fillable = [
        'nama', 'email', 'password', 'role'
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
