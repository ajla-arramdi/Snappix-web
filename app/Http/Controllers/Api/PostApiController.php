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
        $posts = PostFoto::with(['user', 'album'])->latest()->get();

        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'caption' => $post->caption,
                'image' => $post->image ? url('storage/' . $post->image) : null,
                'is_banned' => $post->is_banned,
                'banned_at' => $post->banned_at,
                'ban_reason' => $post->ban_reason,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'user' => [
                    'id' => $post->user->id ?? null,
                    'name' => $post->user->name ?? null,
                    'email' => $post->user->email ?? null,
                    'avatar' => $post->user->avatar ? url('storage/' . $post->user->avatar) : null,
                ],
                'album' => $post->album ? [
                    'id' => $post->album->id,
                    'nama_album' => $post->album->nama_album,
                    'deskripsi' => $post->album->deskripsi,
                ] : null
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data post berhasil diambil',
            'data' => $formattedPosts
        ]);
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
        $post->load(['user', 'album']);

        $formattedPost = [
            'id' => $post->id,
            'caption' => $post->caption,
            'image' => $post->image ? url('storage/' . $post->image) : null,
            'is_banned' => $post->is_banned,
            'banned_at' => $post->banned_at,
            'ban_reason' => $post->ban_reason,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user' => [
                'id' => $post->user->id ?? null,
                'name' => $post->user->name ?? null,
                'email' => $post->user->email ?? null,
                'avatar' => $post->user->avatar ? url('storage/' . $post->user->avatar) : null,
            ],
            'album' => $post->album ? [
                'id' => $post->album->id,
                'nama_album' => $post->album->nama_album,
                'deskripsi' => $post->album->deskripsi,
            ] : null
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data post berhasil diambil',
            'data' => $formattedPost
        ]);
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
