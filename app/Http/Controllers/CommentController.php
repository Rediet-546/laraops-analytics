<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|min:2|max:1000'
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user_avatar' => $comment->user->avatar ? Storage::url($comment->user->avatar) : null
                ]
            ]);
        }

        return back()->with('success', 'Comment added!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Comment deleted!');
    }
}