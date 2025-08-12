<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    public function index()
    {
        $posts = PostFoto::with('user')->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'album_id'  => 'required|exists:albums,id',
            'gambar'    => 'required', // bisa URL atau file upload
        ]);

        // Jika file upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $path = $request->file('gambar')->store('posts', 'public');
            $validated['gambar'] = $path;
        }

        // Set user id
        $validated['user_id'] = auth()->id();

        $post = PostFoto::create($validated);

        return response()->json($post, 201);
    }

    public function show(PostFoto $post)
    {
        $post->load('user');
        return response()->json($post);
    }

    public function update(Request $request, PostFoto $post)
    {
        $validated = $request->validate([
            'judul'     => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'album_id'  => 'sometimes|exists:albums,id',
            'gambar'    => 'nullable',
        ]);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
                Storage::disk('public')->delete($post->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('posts', 'public');
        }

        $post->update($validated);

        return response()->json($post);
    }

    public function destroy(PostFoto $post)
    {
        if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
            Storage::disk('public')->delete($post->gambar);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
