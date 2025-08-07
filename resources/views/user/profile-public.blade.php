@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- User Info -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <div class="flex items-center space-x-6">
                <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                    <span class="text-white text-3xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-2">{{ $user->postFotos->count() }} posts</p>
                </div>
            </div>
        </div>

        <!-- User Posts -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-6">Posts</h2>
            
            @if($posts->count() > 0)
                <div class="space-y-8">
                    @foreach($posts as $post)
                        @include('components.post-card', ['post' => $post])
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-images text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">No posts yet</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection