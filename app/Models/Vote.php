<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'votable_id', 'votable_type', 'is_upvote', 'type'
    ];

    protected $casts = [
        'is_upvote' => 'boolean',
    ];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return $this->is_upvote ? 'upvote' : 'downvote';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votable()
    {
        return $this->morphTo();
    }
}

