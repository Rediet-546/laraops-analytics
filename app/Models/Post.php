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
}
