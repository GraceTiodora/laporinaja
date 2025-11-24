<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'date_of_birth',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: User has many Reports
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'id_user', 'id_user');
    }

    /**
     * Relationship: User has many Comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user', 'id_user');
    }

    /**
     * Relationship: User has many Votes
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_user', 'id_user');
    }

    /**
     * Relationship: User has many Notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user', 'id_user');
    }

    /**
     * Check password
     */
    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Get by username
     */
    public static function findByUsername($username)
    {
        return self::where('username', $username)->first();
    }
}
