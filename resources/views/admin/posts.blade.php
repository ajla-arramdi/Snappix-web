@extends('layouts.admin')

@section('title', 'Kelola Postingan')
@section('page-title', 'Kelola Postingan')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Daftar Postingan</h3>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">Total: {{ $posts->total() }} postingan</span>
                <div class="flex items-center space-x-2">
                    <select class="text-sm border-gray-300 rounded-md">
                        <option value="all">Semua Postingan</option>
                        <option value="active">Aktif</option>
                        <option value="banned">Dibanned</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <!-- Post Image -->
                <div class="relative">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post Image" 
                             class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    @if($post->is_banned)
                        <span class="absolute top-2 right-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-ban mr-1"></i>
                            Banned
                        </span>
                    @else
                        <span class="absolute top-2 right-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Active
                        </span>
                    @endif
                </div>

                <!-- Post Content -->
                <div class="p-4">
                    <!-- User Info -->
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                            <span class="text-white font-medium text-xs">
                                {{ strtoupper(substr($post->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Caption -->
                    <p class="text-sm text-gray-700 mb-3 line-clamp-2">{{ $post->caption }}</p>

                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-heart mr-1 text-red-400"></i>
                                {{ $post->likeFotos->count() }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-comment mr-1 text-blue-400"></i>
                                {{ $post->komentarFotos->count() }}
                            </span>
                        </div>
                        <span class="text-xs">{{ $post->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.post-detail', $post->id) }}" 
                           class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </a>

                        <div class="flex items-center space-x-1">
                            @if($post->is_banned)
                                <form method="POST" action="{{ route('admin.unban-post', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-green-600 hover:bg-green-700 transition">
                                        <i class="fas fa-unlock text-xs"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.ban-post', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition"
                                            onclick="return confirm('Yakin ingin ban postingan ini?')">
                                        <i class="fas fa-ban text-xs"></i>
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.delete-post', $post) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-white bg-red-600 hover:bg-red-700 transition"
                                        onclick="return confirm('Yakin ingin hapus postingan ini?')">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-images text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada postingan</h3>
                    <p class="text-gray-500">Belum ada postingan yang dibuat oleh user.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-images text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Total Posts</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $posts->total() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Active Posts</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $posts->filter(fn($p) => !$p->is_banned)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-ban text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Banned Posts</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $posts->filter(fn($p) => $p->is_banned)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-heart text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Total Likes</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $posts->sum(fn($p) => $p->likeFotos->count()) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection