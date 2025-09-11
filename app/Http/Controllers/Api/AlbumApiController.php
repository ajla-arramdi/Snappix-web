<?php

namespace App\Http\Controllers\Api;

use App\Models\Album;
use App\Models\PostFoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AlbumApiController extends Controller
{
    public function index()
    {
        $albums = Album::where('user_id', Auth::id())->get();
        return response()->json($albums);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $album = Album::create([
            'user_id' => Auth::id(),
            'nama_album' => $request->nama_album,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json($album, 201);
    }

    public function show($id)
    {
        $album = Album::findOrFail($id);
        return response()->json($album);
    }

    public function getAlbumsByUserId($userId)
    {
        $albums = Album::where('user_id', $userId)
            ->with(['user', 'postFotos'])
            ->latest()
            ->paginate(10);

        return response()->json($albums);
    }

    public function getPostsByAlbum($albumId)
    {
        $album = Album::findOrFail($albumId);

        // Opsional: Cek apakah album publik atau milik user sendiri
        // if ($album->user_id !== Auth::id()) {
        //     // Tambahkan logika privasi di sini
        // }

        $posts = PostFoto::where('album_id', $albumId)
            ->with(['user', 'album'])
            ->latest()
            ->paginate(10);

        return response()->json($posts);
    }



    public function destroy($id)
    {
        $album = Album::where('user_id', Auth::id())->findOrFail($id);
        $album->delete();

        return response()->json(['message' => 'Album deleted successfully']);
    }

}
