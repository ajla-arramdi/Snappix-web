@extends('layouts.app')

@section('title', 'Create New Album')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-8">
    <div class="container mx-auto px-4 max-w-xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-folder-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Album</h1>
            <p class="text-gray-600">Organize your photos beautifully</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form method="POST" action="{{ route('user.albums.store') }}">
                @csrf
                
                <!-- Form Fields -->
                <div class="p-8 space-y-6">
                    <!-- Album Name -->
                    <div>
                        <label class="block text-gray-800 text-lg font-semibold mb-3">
                            <i class="fas fa-tag mr-2 text-blue-500"></i>Album Name
                        </label>
                        <input type="text" name="nama_album" required 
                               value="{{ old('nama_album') }}"
                               placeholder="Enter album name..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('nama_album')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-gray-800 text-lg font-semibold mb-3">
                            <i class="fas fa-align-left mr-2 text-green-500"></i>Description
                        </label>
                        <textarea name="deskripsi" rows="4" 
                                  placeholder="Describe your album..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('deskripsi') }}</textarea>
                        <p class="text-sm text-gray-500 mt-2">Tell people what this album is about</p>
                    </div>

                    <!-- Preview Card -->
                    <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-xl p-6 border border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-3">
                            <i class="fas fa-eye mr-2 text-purple-500"></i>Preview
                        </h3>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                    <h4 id="previewName" class="font-semibold text-gray-900">Album Name</h4>
                                    <p id="previewDesc" class="text-sm text-gray-600">Album description</p>
                                    <p class="text-xs text-gray-500">0 photos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('user.albums.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </a>
                    <button type="submit" 
                            class="flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Create Album
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="nama_album"]');
    const descInput = document.querySelector('textarea[name="deskripsi"]');
    const previewName = document.getElementById('previewName');
    const previewDesc = document.getElementById('previewDesc');

    // Live preview
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Album Name';
    });

    descInput.addEventListener('input', function() {
        previewDesc.textContent = this.value || 'Album description';
    });
});
</script>
@endsection

