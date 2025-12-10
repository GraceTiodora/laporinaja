<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id', 'user_id', 'description', 'image', 'upvotes', 'downvotes', 'is_accepted'
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
