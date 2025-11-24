<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notification';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'type',
        'title',
        'message',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Notification belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get unread count for user
     */
    public static function getUnreadCount($userId)
    {
        return self::where('id_user', $userId)
                   ->where('read', false)
                   ->count();
    }

    /**
     * Create new notification
     */
    public static function createNew($userId, $type, $title, $message)
    {
        return self::create([
            'id_user' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'read' => false,
        ]);
    }
}
