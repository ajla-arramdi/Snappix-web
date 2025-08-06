@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Postingan</h1>

        <form method="POST" action="{{ route('user.posts.update', $post) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Foto Saat Ini</label>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="w-full h-64 object-cover rounded mb-4">
                
                <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Foto (Opsional)</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-3 py-2 border rounded" id="imageInput">
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" class="max-w-full h-64 object-cover rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Caption</label>
                <textarea name="caption" rows="4" placeholder="Tulis caption untuk foto Anda..." 
                          class="w-full px-3 py-2 border rounded">{{ old('caption', $post->caption) }}</textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Update Postingan
                </button>
                <a href="{{ route('user.posts.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection