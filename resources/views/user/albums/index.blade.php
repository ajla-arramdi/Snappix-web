@extends('layouts.app')

@section('title', 'My Albums')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Albums</h1>
                    <p class="text-gray-600 mt-1">Organize and manage your photo collections</p>
                </div>
                <a href="{{ route('user.albums.create') }}" 
                   class="flex items-center bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>New Album
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

        @if($albums->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($albums as $album)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <!-- Album Cover -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-400 to-purple-600 overflow-hidden">
                        @if($album->postFotos->count() > 0)
                            <img src="{{ asset('storage/' . $album->postFotos->first()->image) }}" 
                                 alt="{{ $album->nama_album }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-folder text-white text-4xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300">
                            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex space-x-2">
                                    <a href="{{ route('user.albums.show', $album) }}" 
                                       class="bg-white/90 hover:bg-white text-gray-800 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <form method="POST" action="{{ route('user.albums.destroy', $album) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Delete this album?')"
                                                class="bg-red-500/90 hover:bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Photo Count Badge -->
                        <div class="absolute bottom-3 left-3">
                            <span class="bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $album->postFotos->count() }} photos
                            </span>
                        </div>
                    </div>
                    
                    <!-- Album Info -->
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $album->nama_album }}
                        </h3>
                        @if($album->deskripsi)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $album->deskripsi }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $album->created_at->format('M d, Y') }}
                            </span>
                            <a href="{{ route('user.albums.show', $album) }}" 
                               class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                View Album →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-folder-plus text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No albums yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Create your first album to organize your photos beautifully
                </p>
                <a href="{{ route('user.albums.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Create Your First Album
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


