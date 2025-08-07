@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-gray-100">
            <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8">
                <!-- Avatar Section -->
                <div class="flex-shrink-0 relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="Avatar" 
                             class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-2xl">
                    @else
                        <div class="w-40 h-40 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-2xl">
                            <span class="text-white text-5xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-6 mb-6">
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-2 lg:mb-0">
                            {{ $user->name }}
                        </h1>
                        <button onclick="toggleEditForm()" 
                                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg font-medium">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </button>
                    </div>
                    
                    <p class="text-gray-600 mb-6 text-lg">{{ $user->email }}</p>
                    
                    <!-- Enhanced Stats -->
                    <div class="grid grid-cols-3 gap-8 mb-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-images text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-gray-900">{{ $user->postFotos->count() }}</div>
                            <div class="text-gray-600 font-medium">Posts</div>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-folder text-purple-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-gray-900">{{ $user->albums->count() }}</div>
                            <div class="text-gray-600 font-medium">Albums</div>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-calendar text-green-600 text-xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-gray-900">{{ $user->created_at->format('Y') }}</div>
                            <div class="text-gray-600 font-medium">Joined</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form (Hidden by default) -->
        <div id="editForm" class="hidden bg-white rounded-3xl shadow-xl p-8 mb-8 border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h3>
            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Profile Photo</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                            <input type="file" name="avatar" accept="image/*" 
                                   class="hidden" id="avatarInput">
                            <label for="avatarInput" class="cursor-pointer">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-camera text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-600">Click to upload new photo</p>
                            </label>
                        </div>
                        <div id="avatarPreview" class="mt-4 hidden text-center">
                            <img id="preview" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 mx-auto">
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div class="flex space-x-4">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 font-medium">
                                Save Changes
                            </button>
                            <button type="button" onclick="toggleEditForm()" 
                                    class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Content Tabs -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="border-b border-gray-200 bg-gray-50">
                <nav class="flex space-x-8 px-8">
                    <button onclick="showTab('posts')" 
                            class="tab-button py-6 px-4 border-b-2 font-semibold text-sm active flex items-center space-x-2"
                            data-tab="posts">
                        <i class="fas fa-images"></i>
                        <span>Posts</span>
                    </button>
                    <button onclick="showTab('albums')" 
                            class="tab-button py-6 px-4 border-b-2 font-semibold text-sm flex items-center space-x-2"
                            data-tab="albums">
                        <i class="fas fa-folder"></i>
                        <span>Albums</span>
                    </button>
                </nav>
            </div>

            <!-- Posts Tab -->
            <div id="posts-tab" class="tab-content p-8">
                @if($user->postFotos->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($user->postFotos->take(12) as $post)
                        <div class="group aspect-square bg-gray-200 rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 alt="{{ $post->caption }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-white text-center">
                                    <i class="fas fa-heart text-lg mb-1"></i>
                                    <p class="text-sm">{{ $post->likeFotos->count() }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-images text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No posts yet</h3>
                        <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">Start sharing your amazing photos with the world!</p>
                        <a href="{{ route('user.posts.create') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg font-medium">
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
                        <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1">
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
                                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endforeach
                                
                                @for($i = $album->postFotos->count(); $i < 3; $i++)
                                    <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-plus text-gray-400 text-xl"></i>
                                    </div>
                                @endfor
                            </div>
                            
                            <a href="{{ route('user.albums.show', $album) }}" 
                               class="block bg-gradient-to-r from-purple-500 to-pink-600 text-white text-center py-3 rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-300 font-medium">
                                View Album
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-folder text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No albums yet</h3>
                        <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">Create albums to organize your photos beautifully</p>
                        <a href="{{ route('user.albums.create') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-purple-500 to-pink-600 text-white px-8 py-4 rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg font-medium">
                            <i class="fas fa-folder-plus mr-2"></i>Create Your First Album
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.tab-button.active {
    border-color: #3B82F6 !important;
    color: #3B82F6 !important;
    background: linear-gradient(to bottom, transparent, rgba(59, 130, 246, 0.1));
}

.tab-button:not(.active) {
    border-color: transparent;
    color: #6B7280;
}

.tab-button:hover:not(.active) {
    color: #374151;
    background: rgba(0, 0, 0, 0.05);
}
</style>

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
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to selected button
    const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
    activeBtn.classList.add('active');
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
@endsection


