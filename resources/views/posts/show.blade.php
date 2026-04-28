@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Post Content -->
    <article class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        <div class="text-sm text-gray-500 mb-6 pb-4 border-b">
            By {{ $post->user->name }} • {{ $post->published_at->format('F j, Y') }}
            @can('update', $post)
                <div class="mt-2 space-x-2">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>
                </div>
            @endcan
        </div>
        <div class="text-gray-700 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <!-- Comments Section -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">
            Comments ({{ $post->comments->count() }})
        </h2>

        @auth
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <textarea id="commentContent" rows="3" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500"
                          placeholder="Write a comment..."></textarea>
                <div class="mt-2 text-right">
                    <button onclick="submitComment({{ $post->id }})" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                        Post Comment
                    </button>
                </div>
                <p id="commentError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>
        @else
            <div class="mb-8 p-4 bg-gray-50 rounded-lg text-center">
                <a href="{{ route('login') }}" class="text-blue-600">Login</a> to comment
            </div>
        @endauth

        <div id="commentsList" class="space-y-4">
            @foreach($post->comments as $comment)
                <div id="comment-{{ $comment->id }}" class="border-b pb-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <strong class="text-gray-800">{{ $comment->user->name }}</strong>
                                <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                        @can('delete', $comment)
                            <button onclick="deleteComment({{ $comment->id }})" 
                                    class="text-red-500 hover:text-red-700 text-sm">
                                Delete
                            </button>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function submitComment(postId) {
    const content = document.getElementById('commentContent').value;
    const errorDiv = document.getElementById('commentError');
    
    if (!content.trim()) {
        errorDiv.textContent = 'Please write a comment';
        errorDiv.classList.remove('hidden');
        return;
    }
    
    errorDiv.classList.add('hidden');
    
    fetch(`/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ content: content })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('commentContent').value = '';
            const commentsList = document.getElementById('commentsList');
            const newComment = `
                <div id="comment-${data.comment.id}" class="border-b pb-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <strong class="text-gray-800">${data.comment.user_name}</strong>
                                <span class="text-gray-500 text-sm">${data.comment.created_at}</span>
                            </div>
                            <p class="text-gray-700">${data.comment.content}</p>
                        </div>
                        <button onclick="deleteComment(${data.comment.id})" 
                                class="text-red-500 hover:text-red-700 text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            `;
            commentsList.insertAdjacentHTML('afterbegin', newComment);
            
            const commentCount = document.querySelector('h2');
            const currentCount = parseInt(commentCount.textContent.match(/\d+/)[0]);
            commentCount.textContent = `Comments (${currentCount + 1})`;
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Something went wrong';
        errorDiv.classList.remove('hidden');
    });
}

function deleteComment(commentId) {
    if (!confirm('Delete this comment?')) return;
    
    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            commentElement.remove();
            
            const commentCount = document.querySelector('h2');
            const currentCount = parseInt(commentCount.textContent.match(/\d+/)[0]);
            commentCount.textContent = `Comments (${currentCount - 1})`;
        }
    });
}
</script>
@endsection