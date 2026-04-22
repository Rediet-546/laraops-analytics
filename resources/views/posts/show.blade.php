@extends('layouts.app')

@section('title', \->title)

@section('content')
<div class=\"max-w-4xl mx-auto\">
    <article class=\"bg-white rounded-xl shadow-lg p-8 mb-8\">
        <h1 class=\"text-4xl font-bold mb-4\">{{\->title}}</h1>
        <div class=\"text-sm text-gray-500 mb-6 pb-4 border-b\">
            By {{\->user->name}} • {{\->published_at->format('F j, Y')}}
            @can('update', \)
                <div class=\"mt-2 space-x-2\">
                    <a href=\"{{ route('posts.edit', \) }}\" class=\"text-blue-600\">Edit</a>
                    <form action=\"{{ route('posts.destroy', \) }}\" method=\"POST\" class=\"inline\">
                        @csrf @method('DELETE')
                        <button type=\"submit\" class=\"text-red-600\">Delete</button>
                    </form>
                </div>
            @endcan
        </div>
        <div class=\"text-gray-700 leading-relaxed\">
            {!! nl2br(e(\->content)) !!}
        </div>
    </article>

    <!-- Comments Section -->
    <div class=\"bg-white rounded-xl shadow-lg p-8\">
        <h2 class=\"text-2xl font-bold mb-6\">?? Comments ({{ \->comments->count() }})</h2>

        <!-- Display Comments -->
        @forelse(\->comments as \)
            <div class=\"border-b border-gray-100 pb-4 mb-4\">
                <div class=\"flex justify-between items-start\">
                    <div>
                        <strong class=\"text-blue-600\">{{ \->user->name }}</strong>
                        <span class=\"text-xs text-gray-400 ml-2\">{{ \->created_at->diffForHumans() }}</span>
                    </div>
                    @can('delete', \)
                        <form action=\"{{ route('comments.destroy', \) }}\" method=\"POST\">
                            @csrf @method('DELETE')
                            <button type=\"submit\" class=\"text-red-400 hover:text-red-600 text-sm\">Delete</button>
                        </form>
                    @endcan
                </div>
                <p class=\"text-gray-700 mt-2\">{{ \->content }}</p>
            </div>
        @empty
            <p class=\"text-gray-500\">No comments yet. Be the first to comment!</p>
        @endforelse

        <!-- Add Comment Form -->
        @auth
            <div class=\"mt-6 pt-4 border-t\">
                <h3 class=\"font-semibold mb-3\">Leave a Comment</h3>
                <form action=\"{{ route('comments.store', \) }}\" method=\"POST\">
                    @csrf
                    <textarea name=\"content\" rows=\"3\" 
                              class=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500\"
                              placeholder=\"Write your comment...\" required></textarea>
                    @error('content')
                        <p class=\"text-red-500 text-sm mt-1\">{{ \ }}</p>
                    @enderror
                    <button type=\"submit\" 
                            class=\"mt-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition\">
                        Post Comment
                    </button>
                </form>
            </div>
        @else
            <div class=\"mt-6 pt-4 border-t text-center\">
                <a href=\"{{ route('login') }}\" class=\"text-blue-600 hover:text-blue-700\">Login to comment</a>
            </div>
        @endauth
    </div>

    <div class=\"mt-8 text-center\">
        <a href=\"{{ route('home') }}\" class=\"text-blue-600\">? Back to all posts</a>
    </div>
</div>
@endsection
