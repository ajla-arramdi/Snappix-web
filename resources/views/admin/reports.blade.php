@extends('layouts.admin')

@section('page-title', 'Kelola Laporan')
@section('page-description', 'Dashboard monitoring dan review laporan pengguna')

@section('content')
<div style="padding: 32px;">
    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">
        <!-- Pending -->
        <div style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: between;">
                <div>
                    <p style="font-size: 14px; opacity: 0.9; margin: 0 0 8px 0;">⏳ Pending</p>
                    <p style="font-size: 32px; font-weight: 700; margin: 0;">{{ $reportPosts->where('status', 'pending')->count() + $reportComments->where('status', 'pending')->count() + $reportUsers->where('status', 'pending')->count() }}</p>
                </div>
                <i class="fas fa-hourglass-half" style="font-size: 24px; opacity: 0.8;"></i>
            </div>
        </div>

        <!-- Disetujui -->
        <div style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: between;">
                <div>
                    <p style="font-size: 14px; opacity: 0.9; margin: 0 0 8px 0;">✅ Disetujui</p>
                    <p style="font-size: 32px; font-weight: 700; margin: 0;">{{ $reportPosts->where('status', 'approved')->count() + $reportComments->where('status', 'approved')->count() + $reportUsers->where('status', 'approved')->count() }}</p>
                </div>
                <i class="fas fa-check-circle" style="font-size: 24px; opacity: 0.8;"></i>
            </div>
        </div>

        <!-- Ditolak -->
        <div style="background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: between;">
                <div>
                    <p style="font-size: 14px; opacity: 0.9; margin: 0 0 8px 0;">❌ Ditolak</p>
                    <p style="font-size: 32px; font-weight: 700; margin: 0;">{{ $reportPosts->where('status', 'rejected')->count() + $reportComments->where('status', 'rejected')->count() + $reportUsers->where('status', 'rejected')->count() }}</p>
                </div>
                <i class="fas fa-times-circle" style="font-size: 24px; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 24px;">
        <div style="border-bottom: 1px solid #e2e8f0; padding: 0 24px;">
            <nav style="display: flex; gap: 0;">
                <button onclick="showTab('posts')" id="tab-posts" class="tab-button" style="padding: 16px 24px; border: none; background: none; font-weight: 600; color: #3b82f6; border-bottom: 2px solid #3b82f6;">
                    📸 Laporan Post ({{ $reportPosts->count() }})
                </button>
                <button onclick="showTab('comments')" id="tab-comments" class="tab-button" style="padding: 16px 24px; border: none; background: none; font-weight: 600; color: #64748b; border-bottom: 2px solid transparent;">
                    💬 Laporan Komentar ({{ $reportComments->count() }})
                </button>
                <button onclick="showTab('users')" id="tab-users" class="tab-button" style="padding: 16px 24px; border: none; background: none; font-weight: 600; color: #64748b; border-bottom: 2px solid transparent;">
                    👤 Laporan User ({{ $reportUsers->count() }})
                </button>
            </nav>
        </div>

        <!-- Content Posts -->
        <div id="content-posts" class="tab-content" style="padding: 24px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">📸 Laporan Postingan</h3>
            
            @if($reportPosts->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Pelapor</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Post</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Alasan</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Status</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportPosts as $report)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 12px;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $report->user->name }}</div>
                                        <div style="font-size: 12px; color: #64748b;">{{ $report->created_at->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 500; color: #374151;">{{ Str::limit($report->postFoto->caption ?? 'Post dihapus', 40) }}</div>
                                    <div style="font-size: 12px; color: #64748b;">oleh {{ $report->postFoto->user->name ?? 'User dihapus' }}</div>
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 500; color: #dc2626;">{{ $report->alasan }}</div>
                                    @if($report->deskripsi)
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ Str::limit($report->deskripsi, 50) }}</div>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @if($report->status === 'pending')
                                        <span style="background: #fbbf24; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">⏳ Pending</span>
                                    @elseif($report->status === 'approved')
                                        <span style="background: #10b981; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">✅ Disetujui</span>
                                    @else
                                        <span style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">❌ Ditolak</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @if($report->status === 'pending')
                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="openReviewModal('post', {{ $report->id }}, 'approve')" 
                                                    style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ✅ Setujui
                                            </button>
                                            <button onclick="openReviewModal('post', {{ $report->id }}, 'reject')" 
                                                    style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ❌ Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span style="color: #64748b; font-size: 12px;">✅ Sudah direview</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($reportPosts->hasPages())
                    <div style="margin-top: 24px;">
                        {{ $reportPosts->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 48px; color: #64748b;">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 16px;">Tidak ada laporan post</p>
                </div>
            @endif
        </div>

        <!-- Content Comments -->
        <div id="content-comments" class="tab-content" style="padding: 24px; display: none;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">💬 Laporan Komentar</h3>
            @if($reportComments->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Pelapor</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Komentar</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Alasan</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Status</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportComments as $report)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 12px;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $report->user->name }}</div>
                                        <div style="font-size: 12px; color: #64748b;">{{ $report->created_at->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 500; color: #374151;">{{ Str::limit(optional($report->comment)->isi_komentar ?? 'Komentar dihapus', 60) }}</div>
                                    <div style="font-size: 12px; color: #64748b;">oleh {{ optional(optional($report->comment)->user)->name ?? 'User dihapus' }}</div>
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 500; color: #dc2626;">{{ $report->alasan }}</div>
                                    @if($report->deskripsi)
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ Str::limit($report->deskripsi, 60) }}</div>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @php $status = $report->status ?? 'pending'; @endphp
                                    @if($status === 'pending')
                                        <span style="background: #fbbf24; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">⏳ Pending</span>
                                    @elseif($status === 'approved')
                                        <span style="background: #10b981; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">✅ Disetujui</span>
                                    @else
                                        <span style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">❌ Ditolak</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @if(($report->status ?? 'pending') === 'pending')
                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="openReviewModal('comment', {{ $report->id }}, 'approve')" 
                                                    style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ✅ Setujui (Hapus)
                                            </button>
                                            <button onclick="openReviewModal('comment', {{ $report->id }}, 'reject')" 
                                                    style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ❌ Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span style="color: #64748b; font-size: 12px;">✅ Sudah direview</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($reportComments->hasPages())
                    <div style="margin-top: 24px;">
                        {{ $reportComments->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 48px; color: #64748b;">
                    <i class="fas fa-comments" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 16px;">Tidak ada laporan komentar</p>
                </div>
            @endif
        </div>

        <!-- Content Users -->
        <div id="content-users" class="tab-content" style="padding: 24px; display: none;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">👤 Laporan User</h3>
            @if($reportUsers->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Pelapor</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">User Dilaporkan</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Alasan</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Status</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e2e8f0;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportUsers as $report)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 12px;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $report->reporter->name }}</div>
                                        <div style="font-size: 12px; color: #64748b;">{{ $report->created_at->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 600; color: #374151;">{{ $report->reportedUser->name ?? 'User dihapus' }}</div>
                                    @if($report->reportedUser)
                                    <div style="font-size: 12px; color: #64748b;">Status: {{ $report->reportedUser->is_banned ? 'Banned' : 'Aktif' }}</div>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    <div style="font-weight: 500; color: #dc2626;">{{ $report->alasan }}</div>
                                    @if($report->deskripsi)
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ Str::limit($report->deskripsi, 60) }}</div>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @if($report->status === 'pending')
                                        <span style="background: #fbbf24; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">⏳ Pending</span>
                                    @elseif($report->status === 'approved')
                                        <span style="background: #10b981; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">✅ Disetujui</span>
                                    @else
                                        <span style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">❌ Ditolak</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px;">
                                    @if($report->status === 'pending')
                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="openReviewModal('user', {{ $report->id }}, 'approve')" 
                                                    style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ✅ Setujui (Ban)
                                            </button>
                                            <button onclick="openReviewModal('user', {{ $report->id }}, 'reject')" 
                                                    style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                ❌ Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span style="color: #64748b; font-size: 12px;">✅ Sudah direview</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($reportUsers->hasPages())
                    <div style="margin-top: 24px;">
                        {{ $reportUsers->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 48px; color: #64748b;">
                    <i class="fas fa-user-slash" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 16px;">Tidak ada laporan user</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.style.color = '#64748b';
        button.style.borderBottomColor = 'transparent';
    });
    
    // Show selected content
    document.getElementById('content-' + tabName).style.display = 'block';
    
    // Add active class to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.style.color = '#3b82f6';
    activeButton.style.borderBottomColor = '#3b82f6';
}

function openReviewModal(type, id, action) {
    const actionText = action === 'approve' ? 'menyetujui' : 'menolak';
    const confirmText = `Apakah Anda yakin ingin ${actionText} laporan ini?`;
    
    if (confirm(confirmText)) {
        // Show loading state
        const buttons = document.querySelectorAll(`button[onclick*="${id}"]`);
        buttons.forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        });

        // Send request - perbaiki URL
        fetch(`/admin/reports/${type}/${id}/${action}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                admin_notes: action === 'reject' ? 'Ditolak oleh admin' : 'Disetujui oleh admin'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || `Laporan berhasil ${action === 'approve' ? 'disetujui' : 'ditolak'}!`, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message || 'Terjadi kesalahan saat memproses laporan', 'error');
            
            // Reset buttons
            buttons.forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
                if (btn.onclick.toString().includes('approve')) {
                    btn.innerHTML = '✅ Setujui';
                } else {
                    btn.innerHTML = '❌ Tolak';
                }
            });
        });
    }
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 16px 24px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 400px;
    `;
    
    if (type === 'success') {
        notification.style.background = 'linear-gradient(135deg, #10b981, #059669)';
        notification.innerHTML = `<i class="fas fa-check-circle" style="margin-right: 8px;"></i>${message}`;
    } else {
        notification.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
        notification.innerHTML = `<i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>${message}`;
    }
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Hide notification after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showTab('posts');
});
</script>
@endsection



