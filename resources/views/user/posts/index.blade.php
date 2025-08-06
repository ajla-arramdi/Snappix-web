@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Postingan Saya</h1>
        <a href="{{ route('user.posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Buat Postingan Baru
        </a>
    </div>

    @if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Post Image -->
            <div class="relative">
                <img src="{{ asset('storage/' . $post->image) }}" 
                     alt="{{ $post->caption }}" 
                     class="w-full h-64 object-cover">
                
                <!-- Post Actions Overlay -->
                <div class="absolute top-2 right-2">
                    <div class="relative">
                        <button type="button" onclick="toggleDropdown({{ $post->id }})" 
                                class="bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="{{ route('user.posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Edit Postingan
                            </a>
                            <form method="POST" action="{{ route('user.posts.destroy', $post) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Yakin ingin hapus postingan ini?')"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Hapus Postingan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Post Content -->
            <div class="p-4">
                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($post->caption, 50) }}</p>
                
                <div class="flex justify-between text-sm text-gray-500">
                    <span>{{ $post->likeFotos->count() }} likes</span>
                    <span>{{ $post->komentarFotos->count() }} komentar</span>
                </div>
                
                <div class="mt-2 text-xs text-gray-400">
                    {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada postingan</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai berbagi foto dengan membuat postingan pertama Anda.</p>
            <div class="mt-6">
                <a href="{{ route('user.posts.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Postingan Pertama
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function toggleDropdown(postId) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${postId}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${postId}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
@endsection



