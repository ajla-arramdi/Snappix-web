<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomentarFoto;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class KomentarFotoController extends Controller
{
    public function store(Request $request, PostFoto $postFoto)
    {
        $request->validate([
            'komentar' => 'required|string|max:500'
        ]);

        $komentar = $postFoto->komentarFotos()->create([
            'user_id' => auth()->id(),
            'isi_komentar' => $request->komentar
        ]);

        $komentar->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'komentar' => [
                    'id' => $komentar->id,
                    'isi_komentar' => $komentar->isi_komentar,
                    'user_name' => $komentar->user->name,
                    'created_at' => $komentar->created_at->diffForHumans(),
                    'can_delete' => $komentar->user_id === auth()->id()
                ]
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(KomentarFoto $komentarFoto)
    {
        if ($komentarFoto->user_id !== auth()->id()) {
            abort(403);
        }

        $komentarFoto->delete();

        return response()->json(['success' => true]);
    }
}