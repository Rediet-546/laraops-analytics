@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <h1 class="text-3xl font-bold text-gray-900">📊 Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="text-sm opacity-90">Total Posts</div>
            <div class="text-4xl font-bold">{{ $posts->count() }}</div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="text-sm opacity-90">Total Views</div>
            <div class="text-4xl font-bold">{{ $analyticsSummary['total_views'] }}</div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="text-sm opacity-90">Today's Views</div>
            <div class="text-4xl font-bold">{{ $analyticsSummary['today_views'] }}</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">Your Posts</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($posts as $post)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-800">
                                <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Status: <span class="{{ $post->status === 'published' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                                @if($post->published_at)
                                    • Published {{ $post->published_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-700 text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    You haven't created any posts yet.
                    <a href="{{ route('posts.create') }}" class="text-blue-600 hover:text-blue-700 ml-1">
                        Create your first post →
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection