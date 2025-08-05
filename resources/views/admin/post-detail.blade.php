@extends('layouts.admin')

@section('title', 'Detail Postingan')
@section('page-title', 'Detail Postingan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Post Detail -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow">
            <!-- Post Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                            <span class="text-white font-medium text-sm">
                                {{ strtoupper(substr($post->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $post->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $post->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($post->is_banned)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-ban mr-2"></i>
                            Banned
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>
                            Active
                        </span>
                    @endif
                </div>
            </div>

            <!-- Post Image -->
            <div class="px-6 py-4">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Post Image" 
                         class="w-full max-h-96 object-cover rounded-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                @endif
            </div>

            <!-- Post Caption -->
            <div class="px-6 py-4 border-b border-gray-200">
                <p class="text-gray-700">{{ $post->caption }}</p>
            </div>

            <!-- Post Stats -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-heart text-red-400 mr-2"></i>
                        <span>{{ $post->likeFotos->count() }} likes</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-comment text-blue-400 mr-2"></i>
                        <span>{{ $post->komentarFotos->count() }} komentar</span>
                    </div>
                </div>
            </div>

            <!-- Post Actions -->
            <div class="px-6 py-4">
                <div class="flex items-center space-x-3">
                    @if($post->is_banned)
                        <form method="POST" action="{{ route('admin.unban-post', $post) }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                                <i class="fas fa-unlock mr-2"></i>
                                Unban Post
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.ban-post', $post) }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition"
                                    onclick="return confirm('Yakin ingin ban postingan ini?')">
                                <i class="fas fa-ban mr-2"></i>
                                Ban Post
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.delete-post', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition"
                                onclick="return confirm('Yakin ingin hapus postingan ini?')">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Post
                        </button>
                    </form>

                    <a href="{{ route('admin.posts') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Komentar ({{ $post->komentarFotos->count() }})
                </h3>
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse($post->komentarFotos as $comment)
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-start space-x-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium text-xs">
                                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">{{ $comment->isi_komentar }}</p>
                            
                            <!-- Comment Actions -->
                            <div class="flex items-center space-x-2 mt-2">
                                <form method="POST" action="{{ route('admin.ban-comment', $comment) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs text-yellow-600 hover:text-yellow-800"
                                            onclick="return confirm('Yakin ingin ban komentar ini?')">
                                        <i class="fas fa-ban mr-1"></i>
                                        Ban
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.delete-comment', $comment) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-xs text-red-600 hover:text-red-800"
                                            onclick="return confirm('Yakin ingin hapus komentar ini?')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-comments text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-500">Belum ada komentar</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Likes Section -->
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Likes ({{ $post->likeFotos->count() }})
                </h3>
            </div>

            <div class="max-h-64 overflow-y-auto">
                @forelse($post->likeFotos as $like)
                <div class="px-6 py-3 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="h-6 w-6 rounded-full bg-gradient-to-r from-pink-400 to-red-500 flex items-center justify-center">
                            <span class="text-white font-medium text-xs">
                                {{ strtoupper(substr($like->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $like->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $like->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-heart text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-500">Belum ada yang like</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection