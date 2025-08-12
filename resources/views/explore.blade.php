@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Explore</h1>
                <p class="text-gray-600">Discover amazing photos from our community</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        @if($posts->count() > 0)
            <!-- Masonry Grid -->
            <div class="masonry-grid" id="masonry-container">
                @foreach($posts as $post)
                    <div class="masonry-item">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer group">
                            <!-- Image -->
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->caption }}" 
                                     class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300">
                                    <!-- Actions -->
                                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="toggleLike({{ $post->id }})" 
                                                        class="bg-white/90 hover:bg-white text-gray-800 px-3 py-2 rounded-full shadow-lg transition-colors flex items-center space-x-1"
                                                        data-post-id="{{ $post->id }}">
                                                    <i class="fas fa-heart text-sm {{ $post->isLikedBy(auth()->user()) ? 'text-red-500' : '' }}"></i>
                                                    <span class="like-count text-xs font-medium">{{ $post->likeFotos->count() }}</span>
                                                </button>
                                                <button class="bg-white/90 hover:bg-white text-gray-800 px-3 py-2 rounded-full shadow-lg transition-colors flex items-center space-x-1">
                                                    <i class="fas fa-comment text-sm"></i>
                                                    <span class="text-xs font-medium">{{ $post->comments->count() }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                @if($post->caption)
                                    <p class="text-gray-900 text-sm leading-relaxed mb-3 line-clamp-3">
                                        {{ $post->caption }}
                                    </p>
                                @endif
                                
                                <!-- User Info -->
                                <div class="flex items-center space-x-3">
                                    @if($post->user->avatar)
                                        <img src="{{ asset('storage/' . $post->user->avatar) }}" 
                                             alt="{{ $post->user->name }}" 
                                             class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ substr($post->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $post->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-search text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No posts found</h3>
                <p class="text-gray-600">Be the first to share something amazing!</p>
            </div>
        @endif
    </div>
</div>

<style>
/* Masonry Grid CSS */
.masonry-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    grid-gap: 20px;
    grid-auto-rows: 10px;
}

.masonry-item {
    grid-row-end: span var(--grid-rows);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 1200px) {
    .masonry-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .masonry-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        grid-gap: 15px;
    }
}

@media (max-width: 480px) {
    .masonry-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        grid-gap: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function resizeGridItem(item) {
        const grid = document.querySelector('.masonry-grid');
        const rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
        const rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
        const rowSpan = Math.ceil((item.querySelector('div').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
        item.style.setProperty('--grid-rows', rowSpan);
    }

    function resizeAllGridItems() {
        const allItems = document.querySelectorAll('.masonry-item');
        allItems.forEach(resizeGridItem);
    }

    const images = document.querySelectorAll('.masonry-item img');
    let loadedImages = 0;

    function imageLoaded() {
        loadedImages++;
        if (loadedImages === images.length) {
            resizeAllGridItems();
        }
    }

    images.forEach(img => {
        if (img.complete) {
            imageLoaded();
        } else {
            img.addEventListener('load', imageLoaded);
        }
    });

    window.addEventListener('resize', resizeAllGridItems);
});
</script>
@endsection

