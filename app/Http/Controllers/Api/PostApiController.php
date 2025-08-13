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
            'album_id'  => 'nullable|exists:albums,id',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = $path;
        }

        // Map fields to database columns
        $postData = [
            'user_id' => auth()->id(),
            'album_id' => $validated['album_id'] ?? null,
            'caption' => $validated['judul'], // Map judul to caption
            'image' => $validated['image'],
        ];

        $post = PostFoto::create($postData);

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
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Map fields to database columns
        $updateData = [];
        if (isset($validated['judul'])) {
            $updateData['caption'] = $validated['judul'];
        }
        if (isset($validated['album_id'])) {
            $updateData['album_id'] = $validated['album_id'];
        }
        if (isset($validated['image'])) {
            $updateData['image'] = $validated['image'];
        }

        $post->update($updateData);

        return response()->json($post);
    }

    public function destroy(PostFoto $post)
    {
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
