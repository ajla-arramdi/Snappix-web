<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        $albums = Album::where('user_id', auth()->id())->get();
        return view('user.posts.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:1000',
            'album_id' => 'nullable|exists:albums,id'
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        PostFoto::create([
            'user_id' => auth()->id(),
            'album_id' => $request->album_id,
            'caption' => $request->caption,
            'image' => $imagePath
        ]);

        return redirect()->route('user.posts.index')->with('success', 'Postingan berhasil dibuat');
    }

    public function index()
    {
        $posts = PostFoto::with(['user', 'komentarFotos', 'likeFotos'])->notBanned()
            ->where('user_id', auth()->id())->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.posts.index', compact('posts'));
    }

    public function destroy(PostFoto $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('user.posts.index')->with('success', 'Postingan berhasil dihapus');
    }

    public function edit(PostFoto $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $albums = Album::where('user_id', auth()->id())->get();
        return view('user.posts.edit', compact('post', 'albums'));
    }

    public function update(Request $request, PostFoto $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:1000',
            'album_id' => 'nullable|exists:albums,id'
        ]);

        $data = [
            'caption' => $request->caption,
            'album_id' => $request->album_id
        ];

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        $post->update($data);
        return redirect()->route('user.posts.index')->with('success', 'Postingan berhasil diupdate');
    }

    public function show(PostFoto $post)
    {
        if ($post->is_banned || $post->user->is_banned) {
            abort(404, 'Postingan tidak ditemukan');
        }

        $post->load([
            'user',
            'komentarFotos' => function ($query) {
                $query->notBanned()->with('user')->orderBy('created_at', 'desc');
            },
            'likeFotos.user'
        ]);

        return view('user.posts.show', compact('post'));
    }
}
