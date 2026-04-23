@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">✏️ Edit Post</h1>
        
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Content</label>
                <textarea name="content" rows="12" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500" required>{{ old('content', $post->content) }}</textarea>
                @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg">
                    <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('posts.show', $post) }}" class="px-6 py-2 border rounded-lg">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection