@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                         alt="Avatar" 
                         class="w-40 h-40 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                @else
                    <div class="w-40 h-40 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center shadow-lg">
                        <span class="text-white text-5xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Profile Info -->
            <div class="flex-1 text-center lg:text-left">
                <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-6 mb-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2 lg:mb-0">{{ $user->name }}</h1>
                    <button onclick="toggleEditForm()" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </button>
                </div>
                
                <p class="text-gray-600 mb-6 text-lg">{{ $user->email }}</p>
                
                <!-- Stats -->
                <div class="flex justify-center lg:justify-start space-x-12 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $user->postFotos->count() }}</div>
                        <div class="text-gray-600 font-medium">Posts</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $user->albums->count() }}</div>
                        <div class="text-gray-600 font-medium">Albums</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $user->created_at->format('Y') }}</div>
                        <div class="text-gray-600 font-medium">Joined</div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('user.posts.create') }}" 
                       class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition text-center font-medium">
                        <i class="fas fa-plus mr-2"></i>New Post
                    </a>
                    <a href="{{ route('user.albums.create') }}" 
                       class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition text-center font-medium">
                        <i class="fas fa-folder-plus mr-2"></i>New Album
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form (Hidden by default) -->
    <div id="editForm" class="bg-white rounded-lg shadow-md p-8 mb-8 hidden">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Edit Profile</h3>
            <button onclick="toggleEditForm()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                @foreach ($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Profile Photo</label>
                    <input type="file" name="avatar" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" 
                           id="avatarInput">
                    <div id="avatarPreview" class="mt-4 hidden">
                        <img id="preview" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                </div>
                
                <div class="lg:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>
            
            <div class="flex space-x-4 mt-8">
                <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600 transition font-medium">
                    <i class="fas fa-save mr-2"></i>Update Profile
                </button>
                <button type="button" onclick="toggleEditForm()" 
                        class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 transition font-medium">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Content Tabs -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-8">
                <button onclick="showTab('posts')" 
                        class="tab-button py-4 px-2 border-b-2 font-semibold text-sm active"
                        data-tab="posts">
                    <i class="fas fa-images mr-2"></i>Posts
                </button>
                <button onclick="showTab('albums')" 
                        class="tab-button py-4 px-2 border-b-2 font-semibold text-sm"
                        data-tab="albums">
                    <i class="fas fa-folder mr-2"></i>Albums
                </button>
            </nav>
        </div>

        <!-- Posts Tab -->
        <div id="posts-tab" class="tab-content p-8">
            @if($user->postFotos->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($user->postFotos->take(12) as $post)
                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden group cursor-pointer shadow-md hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="{{ $post->caption }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @endforeach
                </div>
                
                @if($user->postFotos->count() > 12)
                    <div class="text-center mt-8">
                        <a href="{{ route('user.posts.index') }}" 
                           class="text-blue-500 hover:text-blue-600 font-semibold text-lg">
                            View All Posts ({{ $user->postFotos->count() }}) →
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <i class="fas fa-images text-gray-400 text-6xl mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No posts yet</h3>
                    <p class="text-gray-600 mb-8 text-lg">Start sharing your amazing photos with the world!</p>
                    <a href="{{ route('user.posts.create') }}" 
                       class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600 transition font-medium">
                        <i class="fas fa-plus mr-2"></i>Create Your First Post
                    </a>
                </div>
            @endif
        </div>

        <!-- Albums Tab -->
        <div id="albums-tab" class="tab-content p-8 hidden">
            @if($user->albums->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($user->albums as $album)
                    <div class="bg-gray-50 rounded-lg p-6 hover:shadow-lg transition border">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-xl text-gray-900">{{ $album->nama_album }}</h4>
                            <span class="text-sm text-gray-500 bg-gray-200 px-3 py-1 rounded-full">
                                {{ $album->postFotos->count() }} photos
                            </span>
                        </div>
                        
                        @if($album->deskripsi)
                            <p class="text-gray-600 mb-4">{{ Str::limit($album->deskripsi, 100) }}</p>
                        @endif
                        
                        <!-- Album Preview -->
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @foreach($album->postFotos->take(3) as $post)
                                <div class="aspect-square bg-gray-200 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                            
                            @for($i = $album->postFotos->count(); $i < 3; $i++)
                                <div class="aspect-square bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-plus text-gray-400 text-xl"></i>
                                </div>
                            @endfor
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('user.albums.show', $album) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded font-medium hover:bg-blue-600 transition">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <form method="POST" action="{{ route('user.albums.destroy', $album) }}" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this album?')"
                                        class="w-full bg-red-500 text-white py-2 rounded font-medium hover:bg-red-600 transition">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-folder text-gray-400 text-6xl mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No albums yet</h3>
                    <p class="text-gray-600 mb-8 text-lg">Create albums to organize your photos beautifully</p>
                    <a href="{{ route('user.albums.create') }}" 
                       class="bg-purple-500 text-white px-8 py-3 rounded-lg hover:bg-purple-600 transition font-medium">
                        <i class="fas fa-folder-plus mr-2"></i>Create Your First Album
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleEditForm() {
    const form = document.getElementById('editForm');
    form.classList.toggle('hidden');
}

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to selected button
    const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
    activeBtn.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
}

// Avatar preview
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('avatarPreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTab('posts');
});
</script>

<style>
.tab-button.active {
    border-color: #3B82F6 !important;
    color: #3B82F6 !important;
}
</style>
@endsection

