@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-camera text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Post</h1>
            <p class="text-gray-600">Share your amazing moments with the world</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form method="POST" action="{{ route('user.posts.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Image Upload Section -->
                <div class="p-8 border-b border-gray-100">
                    <label class="block text-gray-800 text-lg font-semibold mb-4">
                        <i class="fas fa-image mr-2 text-blue-500"></i>Choose Photo
                    </label>
                    
                    <!-- Upload Area -->
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" required 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                               id="imageInput">
                        
                        <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 hover:bg-blue-50 transition-all duration-300">
                            <div id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2">Drop your image here or click to browse</p>
                                <p class="text-sm text-gray-500">Supports: JPG, PNG, GIF (Max: 2MB)</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-6 hidden">
                        <div class="relative rounded-xl overflow-hidden">
                            <img id="preview" class="w-full h-64 object-cover">
                            <button type="button" onclick="removeImage()" 
                                    class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="p-8 space-y-6">
                    <!-- Album Selection -->
                    <div>
                        <label class="block text-gray-800 text-lg font-semibold mb-3">
                            <i class="fas fa-folder mr-2 text-green-500"></i>Album (Optional)
                        </label>
                        <div class="relative">
                            <select name="album_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white appearance-none">
                                <option value="">Select an album</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                                        {{ $album->nama_album }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Caption -->
                    <div>
                        <label class="block text-gray-800 text-lg font-semibold mb-3">
                            <i class="fas fa-pen mr-2 text-purple-500"></i>Caption
                        </label>
                        <textarea name="caption" rows="4" 
                                  placeholder="Write something about your photo..." 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('caption') }}</textarea>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm text-gray-500">Make it engaging and fun!</span>
                            <span id="charCount" class="text-sm text-gray-400">0/1000</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </a>
                    <button type="submit" 
                            class="flex items-center px-8 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <i class="fas fa-share mr-2"></i>Share Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const uploadArea = document.getElementById('uploadArea');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    const captionTextarea = document.querySelector('textarea[name="caption"]');
    const charCount = document.getElementById('charCount');

    // Image upload handling
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                uploadPlaceholder.classList.add('hidden');
                imagePreview.classList.remove('hidden');
                uploadArea.classList.add('border-green-500', 'bg-green-50');
                uploadArea.classList.remove('border-gray-300');
            }
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });

    // Character count
    captionTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = `${count}/1000`;
        
        if (count > 900) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });
});

function removeImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('uploadArea').classList.remove('border-green-500', 'bg-green-50');
    document.getElementById('uploadArea').classList.add('border-gray-300');
}
</script>
@endsection

