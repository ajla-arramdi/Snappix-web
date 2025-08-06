<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::where('user_id', auth()->id())->latest()->get();
        return view('user.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('user.albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_album' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        Album::create([
            'user_id' => auth()->id(),
            'nama_album' => $request->nama_album,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('user.albums.index')->with('success', 'Album berhasil dibuat!');
    }

    public function show(Album $album)
    {
        $posts = $album->postFotos()->latest()->get();
        return view('user.albums.show', compact('album', 'posts'));
    }

    public function destroy(Album $album)
    {
        if ($album->user_id !== auth()->id()) abort(403);
        
        $album->delete();
        return redirect()->route('user.albums.index')->with('success', 'Album berhasil dihapus!');
    }
}

