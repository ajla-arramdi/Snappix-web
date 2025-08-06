@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Buat Postingan Baru</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('user.posts.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Foto</label>
            <input type="file" name="image" accept="image/*" required 
                   class="w-full px-3 py-2 border rounded" id="imageInput">
            <div id="imagePreview" class="mt-4 hidden">
                <img id="preview" class="max-w-full h-64 object-cover rounded">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Album (Opsional)</label>
            <select name="album_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                <option value="">Pilih Album</option>
                @foreach($albums as $album)
                    <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                        {{ $album->nama_album }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Caption</label>
            <textarea name="caption" rows="4" placeholder="Tulis caption untuk foto Anda..." 
                      class="w-full px-3 py-2 border rounded">{{ old('caption') }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('user.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Posting</button>
        </div>
    </form>
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
