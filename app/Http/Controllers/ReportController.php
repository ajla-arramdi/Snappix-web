<?php

namespace App\Http\Controllers;

use App\Models\PostFoto;
use App\Models\KomentarFoto;
use App\Models\User;
use App\Models\ReportPost;
use App\Models\ReportComment;
use App\Models\ReportUser;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportPost(Request $request, PostFoto $postFoto)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        // Cek apakah user sudah pernah report post ini
        $existingReport = ReportPost::where('user_id', auth()->id())
                                   ->where('post_foto_id', $postFoto->id)
                                   ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan postingan ini sebelumnya'
            ]);
        }

        ReportPost::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $postFoto->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }

    public function reportComment(Request $request, KomentarFoto $komentarFoto)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        // Cek apakah user sudah pernah report comment ini
        $existingReport = ReportComment::where('user_id', auth()->id())
                                      ->where('komentar_foto_id', $komentarFoto->id)
                                      ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan komentar ini sebelumnya'
            ]);
        }

        ReportComment::create([
            'user_id' => auth()->id(),
            'komentar_foto_id' => $komentarFoto->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }

    public function reportUser(Request $request, User $user)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat melaporkan diri sendiri'
            ]);
        }

        // Cek apakah user sudah pernah report user ini
        $existingReport = ReportUser::where('reporter_id', auth()->id())
                                   ->where('reported_user_id', $user->id)
                                   ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan user ini sebelumnya'
            ]);
        }

        ReportUser::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }
}