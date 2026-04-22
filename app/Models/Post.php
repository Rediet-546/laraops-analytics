<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected  = ['title', 'content', 'slug', 'status', 'published_at', 'user_id'];

    protected  = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return \->belongsTo(User::class);
    }

    public function scopePublished(\)
    {
        return \->where('status', 'published')
                     ->whereNotNull('published_at');
    }

// Add this relationship to Post model
public function comments()
{
    return $this->hasMany(Comment::class)->where('is_approved', true);
}

public function allComments()
{
    return $this->hasMany(Comment::class);
}
}