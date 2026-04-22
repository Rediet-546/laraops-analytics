<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request \, Post \)
    {
        \->validate([
            'content' => 'required|min:3|max:1000',
        ]);

        Comment::create([
            'post_id' => \->id,
            'user_id' => Auth::id(),
            'content' => \->content,
            'is_approved' => false, // Auto-approve for now, change to false if you want moderation
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment \)
    {
        \->authorize('delete', \);
        \->delete();
        return back()->with('success', 'Comment deleted!');
    }
}
