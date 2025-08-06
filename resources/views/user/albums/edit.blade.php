@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Album</h1>

        <form method="POST" action="{{ route('user.albums.update', $album) }}" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Album</label>
                <input type="text" name="nama_album" value="{{ old('nama_album', $album->nama_album) }}" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                @error('nama_album')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="4" 
                          class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">{{ old('deskripsi', $album->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Update Album
                </button>
                <a href="{{ route('user.albums.show', $album) }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection