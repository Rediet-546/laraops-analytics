<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected \ = ['post_id', 'user_id', 'content', 'is_approved'];

    protected \ = [
        'is_approved' => 'boolean',
    ];

    public function post()
    {
        return \->belongsTo(Post::class);
    }

    public function user()
    {
        return \->belongsTo(User::class);
    }

    public function scopeApproved(\)
    {
        return \->where('is_approved', true);
    }
}
