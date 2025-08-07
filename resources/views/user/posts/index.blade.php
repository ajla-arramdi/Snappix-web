@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Posts</h1>
                    <p class="text-gray-600 mt-1">Manage your shared moments</p>
                </div>
                <a href="{{ route('user.posts.create') }}" 
                   class="flex items-center bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>New Post
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($posts as $post)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <!-- Post Image -->
                    <div class="relative aspect-square overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="{{ $post->caption }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300">
                            <!-- Stats -->
                            <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex space-x-3 text-white">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-heart"></i>
                                        <span class="text-sm font-medium">{{ $post->likeFotos->count() }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span class="text-sm font-medium">{{ $post->komentarFotos->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex space-x-2">
                                    <a href="{{ route('posts.show', $post) }}" 
                                       class="bg-white/90 hover:bg-white text-gray-800 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('user.posts.edit', $post) }}" 
                                       class="bg-blue-500/90 hover:bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form method="POST" action="{{ route('user.posts.destroy', $post) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Delete this post?')"
                                                class="bg-red-500/90 hover:bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Post Info -->
                    <div class="p-4">
                        @if($post->caption)
                            <p class="text-gray-900 text-sm mb-3 line-clamp-2">{{ $post->caption }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                            @if($post->album)
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    {{ $post->album->nama_album }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-camera text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No posts yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Share your first photo and start building your gallery
                </p>
                <a href="{{ route('user.posts.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-8 py-4 rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Create Your First Post
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection

