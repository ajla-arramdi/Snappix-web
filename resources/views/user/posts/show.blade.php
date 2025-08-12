@extends('layouts.app')

@section('title', 'Post Detail')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Image Section -->
            <div class="md:w-2/3">
                <img src="{{ asset('storage/' . $post->image) }}" 
                     alt="{{ $post->caption }}" 
                     class="w-full h-auto object-cover">
            </div>
            
            <!-- Content Section -->
            <div class="md:w-1/3 flex flex-col">
                <!-- Header -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        @if($post->user->avatar)
                            <img src="{{ asset('storage/' . $post->user->avatar) }}" 
                                 alt="{{ $post->user->name }}" 
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $post->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="relative">
                            <button onclick="toggleMenu({{ $post->id }})" class="text-gray-600 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100 text-lg font-bold">
                                ⋯
                            </button>
                            
                            <div id="menu-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999]">
                                @if($post->user_id !== auth()->id())
                                    <button onclick="openReportModal('post', {{ $post->id }})" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center rounded-t-lg">
                                        🚩 <span class="ml-2">Laporkan Post</span>
                                    </button>
                                    <button onclick="openReportModal('user', {{ $post->user_id }})" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center border-t border-gray-100 rounded-b-lg">
                                        👤 <span class="ml-2">Laporkan User</span>
                                    </button>
                                @else
                                    <button onclick="alert('Edit post')" class="w-full text-left px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 flex items-center rounded-t-lg">
                                        ✏️ <span class="ml-2">Edit Post</span>
                                    </button>
                                    <button onclick="alert('Delete post')" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center border-t border-gray-100 rounded-b-lg">
                                        🗑️ <span class="ml-2">Hapus Post</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Caption -->
                @if($post->caption)
                <div class="p-4 border-b border-gray-200">
                    <p class="text-gray-900">{{ $post->caption }}</p>
                </div>
                @endif

                <!-- Actions -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center space-x-6">
                        <button onclick="toggleLike({{ $post->id }})" 
                                class="flex items-center space-x-2 hover:scale-110 transition-transform"
                                data-post-id="{{ $post->id }}">
                            <i class="fas fa-heart text-xl {{ $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-gray-600' }}"></i>
                            <span class="like-count font-medium">{{ $post->likeFotos->count() }}</span>
                        </button>
                        
                        <button onclick="focusComment()" 
                                class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 transition-colors">
                            <i class="fas fa-comment text-xl"></i>
                            <span class="font-medium">{{ $post->comments->count() }}</span>
                        </button>
                        
                        <button class="text-gray-600 hover:text-green-500 transition-colors">
                            <i class="fas fa-share text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Comments -->
                <div class="flex-1 overflow-y-auto max-h-96">
                    <div id="comments-container" class="p-4 space-y-4">
                        @forelse($post->comments as $comment)
                        <div class="comment-item flex space-x-3" data-comment-id="{{ $comment->id }}">
                            @if($comment->user->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" 
                                     alt="{{ $comment->user->name }}" 
                                     class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    @if(auth()->id() === $comment->user_id)
                                        <button onclick="deleteComment({{ $comment->id }})" 
                                                class="text-red-500 hover:text-red-700 text-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-900 mt-1">{{ $comment->isi_komentar }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No comments yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Add Comment -->
                <div class="p-4 border-t border-gray-200">
                    <form onsubmit="addComment(event)" class="flex items-center space-x-3">
                        <input type="text" 
                               name="isi_komentar" 
                               placeholder="Add a comment..." 
                               id="comment-input"
                               class="flex-1 bg-gray-100 border-none rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors">
                            Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal - pastikan ada di luar container utama -->
<div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="reportTitle" class="text-lg font-semibold text-gray-900">Laporkan</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="reportForm" onsubmit="submitReport(event)">
            <input type="hidden" id="reportType" name="type">
            <input type="hidden" id="reportId" name="id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Laporan *</label>
                <select name="alasan" required class="w-full p-3 border border-gray-300 rounded-lg">
                    <option value="">Pilih alasan...</option>
                    <option value="spam">Spam</option>
                    <option value="konten_tidak_pantas">Konten Tidak Pantas</option>
                    <option value="kekerasan">Kekerasan</option>
                    <option value="ujaran_kebencian">Ujaran Kebencian</option>
                    <option value="hak_cipta">Pelanggaran Hak Cipta</option>
                    <option value="pelecehan">Pelecehan</option>
                    <option value="penipuan">Penipuan</option>
                    <option value="akun_palsu">Akun Palsu</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan lebih detail..." class="w-full p-3 border border-gray-300 rounded-lg"></textarea>
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

<script>
// Debug - pastikan script loaded
console.log('Script loaded');

// Toggle menu
function toggleMenu(postId) {
    console.log('Toggle menu clicked for post:', postId);
    const menu = document.getElementById(`menu-${postId}`);
    if (menu) {
        menu.classList.toggle('hidden');
        console.log('Menu toggled');
    } else {
        console.log('Menu not found');
    }
}

// Report functionality
function openReportModal(type, id) {
    console.log('Opening report modal:', type, id);
    
    const modal = document.getElementById('reportModal');
    if (!modal) {
        console.error('Report modal not found!');
        alert('Modal tidak ditemukan. Pastikan modal sudah ada di halaman.');
        return;
    }
    
    const title = document.getElementById('reportTitle');
    const typeInput = document.getElementById('reportType');
    const idInput = document.getElementById('reportId');
    
    if (typeInput) typeInput.value = type;
    if (idInput) idInput.value = id;
    if (title) title.textContent = type === 'post' ? 'Laporkan Post' : 'Laporkan User';
    
    modal.classList.remove('hidden');
    console.log('Modal opened');
    
    // Close any open menus
    document.querySelectorAll('[id^="menu-"]').forEach(menu => {
        menu.classList.add('hidden');
    });
}

function closeReportModal() {
    console.log('Closing modal');
    const modal = document.getElementById('reportModal');
    if (modal) {
        modal.classList.add('hidden');
        const form = document.getElementById('reportForm');
        if (form) form.reset();
    }
}

function submitReport(event) {
    console.log('Submit report called');
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const type = formData.get('type');
    const id = formData.get('id');
    
    console.log('Report data:', { type, id });
    
    let url;
    if (type === 'post') {
        url = `/report/post/${id}`;
    } else if (type === 'user') {
        url = `/report/user/${id}`;
    }
    
    console.log('Sending to URL:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(async response => {
        console.log('Response status:', response.status);
        const contentType = response.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        }
        const text = await response.text();
        return { ok: response.ok, status: response.status, data: { success: false, message: text } };
    })
    .then(({ ok, status, data }) => {
        console.log('Response data:', data);
        if (ok && data.success) {
            alert('✅ Laporan berhasil dikirim!');
            closeReportModal();
        } else {
            if (status === 401) alert('Silakan login terlebih dahulu.');
            else if (status === 419) alert('Sesi kadaluarsa. Silakan refresh halaman.');
            else alert('❌ ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('❌ Terjadi kesalahan: ' + error.message);
    });
}

// Test function
function testAlert() {
    alert('Test button works!');
}

// Like functionality
function toggleLike(postId) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error(text || 'Unexpected response');
        }
        if (!response.ok) {
            const err = await response.json();
            throw new Error(err.message || 'Request failed');
        }
        return response.json();
    })
    .then(data => {
        const button = document.querySelector(`[data-post-id="${postId}"]`);
        const icon = button.querySelector('i');
        const count = button.querySelector('.like-count');
        
        if (data.liked) {
            icon.classList.add('text-red-500');
            icon.classList.remove('text-gray-600');
        } else {
            icon.classList.remove('text-red-500');
            icon.classList.add('text-gray-600');
        }
        
        count.textContent = data.count;
    })
    .catch(error => {
        console.error('Like error:', error);
        alert('Gagal memproses like. ' + error.message);
    });
}

// Add comment
function addComment(event) {
    event.preventDefault();
    
    const form = event.target;
    const input = form.querySelector('input[name="isi_komentar"]');
    const comment = input.value.trim();
    
    if (!comment) return;
    
    console.log('Adding comment:', comment);
    
    fetch(`/posts/{{ $post->id }}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            isi_komentar: comment
        })
    })
    .then(async response => {
        console.log('Response status:', response.status);
        const contentType = response.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        }
        const text = await response.text();
        return { ok: response.ok, status: response.status, data: { success: false, message: text } };
    })
    .then(({ ok, status, data }) => {
        console.log('Response data:', data);
        if (ok && data.success) {
            location.reload();
        } else {
            if (status === 401) alert('Silakan login terlebih dahulu.');
            else if (status === 419) alert('Sesi kadaluarsa. Silakan refresh halaman.');
            else alert('Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error adding comment:', error);
        alert('Error adding comment: ' + error.message);
    });
}

// Delete comment
function deleteComment(commentId) {
    if (!confirm('Delete this comment?')) return;
    
    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        }
        const text = await response.text();
        return { ok: response.ok, status: response.status, data: { success: false, message: text } };
    })
    .then(({ ok, status, data }) => {
        if (ok && data.success) {
            document.querySelector(`[data-comment-id="${commentId}"]`).remove();
            
            // Update comment count
            const commentCount = document.querySelector('.fa-comment').nextElementSibling;
            commentCount.textContent = parseInt(commentCount.textContent) - 1;
        } else {
            if (status === 401) alert('Silakan login terlebih dahulu.');
            else if (status === 419) alert('Sesi kadaluarsa. Silakan refresh halaman.');
            else alert('Gagal menghapus komentar: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Delete comment error:', error);
        alert('Gagal menghapus komentar. ' + error.message);
    });
}

// Focus comment input
function focusComment() {
    document.getElementById('comment-input').focus();
}
</script>
@endsection








