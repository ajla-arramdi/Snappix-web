<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportPost;
use App\Models\ReportUser;
use App\Models\ReportComment;

class ReportController extends Controller
{
    public function reportPost(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        ReportPost::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }

    public function reportUser(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        ReportUser::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }

    public function reportComment(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        ReportComment::create([
            'user_id' => auth()->id(),
            'komentar_foto_id' => $id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }
}