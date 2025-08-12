<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportComment;
use Illuminate\Http\Request;

class ReportCommentController extends Controller
{
    public function index()
    {
        $reports = ReportComment::with(['user', 'comment.user'])
            ->latest()
            ->paginate(15);

        return view('admin.report_comments.index', compact('reports'));
    }

    public function review(Request $request, ReportComment $report, $action)
    {
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $report->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        // Jika approve, ban komentar
        if ($action === 'approve') {
            $report->comment->update([
                'is_banned' => true,
                'banned_at' => now(),
                'banned_by' => auth()->id(),
                'ban_reason' => 'Dilaporkan & disetujui admin',
            ]);
        }

        return back()->with('success', 'Laporan komentar berhasil diproses.');
    }
}
