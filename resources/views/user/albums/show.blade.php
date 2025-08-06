@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-2">{{ $album->nama_album }}</h1>
    <p class="text-gray-600 mb-6">{{ $album->deskripsi }}</p>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($posts as $post)
        <div class="bg-white rounded shadow">
            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-32 object-cover rounded-t">
            <div class="p-2">
                <p class="text-sm">{{ Str::limit($post->caption, 50) }}</p>
            </div>
        </div>
        @endforeach
    </div>

    @if($posts->isEmpty())
        <p class="text-gray-500 text-center py-8">Belum ada foto di album ini</p>
    @endif
</div>
@endsection