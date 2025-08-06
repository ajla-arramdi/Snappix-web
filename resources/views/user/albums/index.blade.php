@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Album Saya</h1>
        <a href="{{ route('user.albums.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Buat Album
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($albums as $album)
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold">{{ $album->nama_album }}</h3>
            <p class="text-gray-600 text-sm">{{ $album->deskripsi }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $album->postFotos->count() }} foto</p>
            
            <div class="mt-3 flex space-x-2">
                <a href="{{ route('user.albums.show', $album) }}" class="text-blue-500 text-sm">Lihat</a>
                <form method="POST" action="{{ route('user.albums.destroy', $album) }}" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 text-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

