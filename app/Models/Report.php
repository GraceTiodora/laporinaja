<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_report';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'title',
        'description',
        'location',
        'category',
        'status',
        'image',
        'votes',
    ];

    protected $casts = [
        'votes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_report', 'id_report');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_report', 'id_report');
    }

    /**
     * Get trending reports (sorted by votes)
     */
    public static function trending($limit = 10)
    {
        return self::orderByDesc('votes')->limit($limit)->get();
    }

    /**
     * Filter reports by criteria
     */
    public static function filter($location = null, $category = null, $status = null, $search = null)
    {
        $query = self::query();

        if ($location) {
            $query->where('location', 'like', "%$location%");
        }
        if ($category) {
            $query->where('category', $category);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%");
            });
        }

        return $query->orderByDesc('votes')->get();
    }
}

