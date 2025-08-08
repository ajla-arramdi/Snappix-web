@extends('layouts.app')

@section('head')
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
                        <p class="text-sm text-gray-600">Discover amazing photos</p>
                    </div>
                </div>
                
               </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        @if($posts->count() > 0)
            <!-- Masonry Grid Container -->
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
                                    <!-- Bottom Actions -->
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
                                                    <span class="text-xs font-medium">{{ $post->komentarFotos->count() }}</span>
                                                </button>
                                            </div>
                                            <a href="{{ route('posts.show', $post) }}" 
                                               class="bg-white/90 hover:bg-white text-gray-800 px-3 py-2 rounded-full shadow-lg transition-colors">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <!-- Caption -->
                                @if($post->caption)
                                    <p class="text-gray-800 text-sm mb-3 line-clamp-3">{{ $post->caption }}</p>
                                @endif
                                
                                <!-- User Info -->
                                <div class="flex items-center space-x-3 mb-4">
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
                                        <a href="{{ route('user.show', $post->user) }}" class="text-sm font-medium text-gray-900 truncate hover:text-blue-600">{{ $post->user->name }}</a>
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
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-images text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No posts yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Be the first to share a photo and inspire others!
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

/* Line clamp utility */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
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
// Masonry layout
document.addEventListener('DOMContentLoaded', function() {
    function resizeGridItem(item) {
        const grid = document.getElementById('masonry-container');
        const rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
        const rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
        const rowSpan = Math.ceil((item.querySelector('.bg-white').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
        item.style.setProperty('--grid-rows', rowSpan);
    }

    function resizeAllGridItems() {
        const allItems = document.querySelectorAll('.masonry-item');
        allItems.forEach(resizeGridItem);
    }

    // Initial resize
    setTimeout(resizeAllGridItems, 100);
    
    // Resize on window resize
    window.addEventListener('resize', resizeAllGridItems);
    
    // Resize when images load
    const images = document.querySelectorAll('.masonry-item img');
    images.forEach(img => {
        img.addEventListener('load', resizeAllGridItems);
    });
});

// Like functionality
function toggleLike(postId) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        const button = document.querySelector(`[data-post-id="${postId}"]`);
        const icon = button.querySelector('i');
        const count = button.querySelector('.like-count');
        
        if (data.liked) {
            icon.classList.add('text-red-500');
        } else {
            icon.classList.remove('text-red-500');
        }
        
        count.textContent = data.likes_count;
    });
}
</script>
@endsection

<!-- Report Post Modal -->
<div id="reportPostModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Laporkan Postingan</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="reportPostForm" onsubmit="submitReport(event, 'post')">
            <input type="hidden" id="reportPostId" name="post_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Laporan *</label>
                <select name="alasan" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih alasan...</option>
                    <option value="spam">Spam</option>
                    <option value="konten_tidak_pantas">Konten Tidak Pantas</option>
                    <option value="kekerasan">Kekerasan</option>
                    <option value="ujaran_kebencian">Ujaran Kebencian</option>
                    <option value="hak_cipta">Pelanggaran Hak Cipta</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan lebih detail..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeReportModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Report Comment Modal -->
<div id="reportCommentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Laporkan Komentar</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="reportCommentForm" onsubmit="submitReport(event, 'comment')">
            <input type="hidden" id="reportCommentId" name="comment_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Laporan *</label>
                <select name="alasan" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih alasan...</option>
                    <option value="spam">Spam</option>
                    <option value="konten_tidak_pantas">Konten Tidak Pantas</option>
                    <option value="ujaran_kebencian">Ujaran Kebencian</option>
                    <option value="pelecehan">Pelecehan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan lebih detail..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeReportModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Report User Modal -->
<div id="reportUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Laporkan User</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="reportUserForm" onsubmit="submitReport(event, 'user')">
            <input type="hidden" id="reportUserId" name="user_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Laporan *</label>
                <select name="alasan" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih alasan...</option>
                    <option value="spam">Spam</option>
                    <option value="pelecehan">Pelecehan</option>
                    <option value="penipuan">Penipuan</option>
                    <option value="akun_palsu">Akun Palsu</option>
                    <option value="ujaran_kebencian">Ujaran Kebencian</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan lebih detail..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeReportModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>





























