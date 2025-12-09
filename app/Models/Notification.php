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
        'user_id',
        'report_id',
        'type',
        'title',
        'message',
        'data',
        'read',
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Notification belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Notification belongs to Report
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }

    /**
     * Get unread count for user
     */
    public static function getUnreadCount($userId)
    {
        return self::where('user_id', $userId)
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
