@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Buat Album Baru</h1>

    <form method="POST" action="{{ route('user.albums.store') }}" class="bg-white p-6 rounded shadow max-w-md">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Nama Album</label>
            <input type="text" name="nama_album" required class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Buat Album</button>
        <a href="{{ route('user.albums.index') }}" class="ml-2 text-gray-500">Batal</a>
    </form>
</div>
@endsection


