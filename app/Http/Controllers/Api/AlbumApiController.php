<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
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
        $album = Album::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($album);
    }

    public function destroy($id)
    {
        $album = Album::where('user_id', Auth::id())->findOrFail($id);
        $album->delete();

        return response()->json(['message' => 'Album deleted successfully']);
    }
}
