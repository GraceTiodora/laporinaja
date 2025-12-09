<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'avatar', 'bio', 'phone', 'address', 'reputation'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id', 'id');
    }
}
