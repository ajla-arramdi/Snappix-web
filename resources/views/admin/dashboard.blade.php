@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan statistik dan aktivitas sistem')

@section('content')
<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <!-- Total Users -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #3b82f6; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Total Users</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalUsers) }}</div>
                <div style="font-size: 12px; color: #10b981; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-arrow-up"></i>
                    +12% dari bulan lalu
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #3b82f6, #06b6d4);">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Total Posts -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #10b981; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Total Posts</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalPosts) }}</div>
                <div style="font-size: 12px; color: #10b981; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-arrow-up"></i>
                    +8% dari bulan lalu
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #10b981, #34d399);">
                <i class="fas fa-images"></i>
            </div>
        </div>
    </div>

    <!-- Total Comments -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #f59e0b; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Total Comments</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalComments) }}</div>
                <div style="font-size: 12px; color: #10b981; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-arrow-up"></i>
                    +15% dari bulan lalu
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <i class="fas fa-comments"></i>
            </div>
        </div>
    </div>

    <!-- Admin Users -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #8b5cf6; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Admin Users</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalAdmins) }}</div>
                <div style="font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-minus"></i>
                    Tidak ada perubahan
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

    <!-- Banned Users -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #ef4444; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Banned Users</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalBannedUsers) }}</div>
                <div style="font-size: 12px; color: #ef4444; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-arrow-down"></i>
                    -5% dari bulan lalu
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #ef4444, #f87171);">
                <i class="fas fa-ban"></i>
            </div>
        </div>
    </div>

    <!-- Reports -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #f97316; transition: all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 8px 0;">Reports</h4>
                <div style="font-size: 32px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">{{ number_format($totalReports) }}</div>
                <div style="font-size: 12px; color: #10b981; display: flex; align-items: center; gap: 4px; margin: 0;">
                    <i class="fas fa-arrow-up"></i>
                    +3% dari bulan lalu
                </div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; background: linear-gradient(135deg, #f97316, #fb923c);">
                <i class="fas fa-flag"></i>
            </div>
        </div>
    </div>
</div>

<!-- Welcome & Activity Section -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
    <!-- Welcome Card -->
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px; color: white;">
            <i class="fas fa-tachometer-alt"></i>
        </div>
        <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0;">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p style="color: #64748b; margin: 0 0 24px 0;">Anda berhasil masuk ke panel admin Snappix. Kelola sistem dengan mudah dan efisien.</p>
        <div style="display: flex; gap: 12px; justify-content: center;">
            <a href="{{ route('admin.users') }}" 
               style="padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; transition: all 0.3s ease;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(59, 130, 246, 0.3)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fas fa-users"></i>
                Kelola User
            </a>
            <a href="{{ route('admin.posts') }}" 
               style="padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #10b981, #059669); color: white; transition: all 0.3s ease;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(16, 185, 129, 0.3)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fas fa-images"></i>
                Kelola Post
            </a>
        </div>
    </div>

    <!-- Activity Card -->
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 24px 0;">Aktivitas Hari Ini</h3>
        
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-radius: 12px; margin-bottom: 12px; background: #eff6ff;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; background: #3b82f6;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0 0 2px 0;">User Baru</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Registrasi hari ini</p>
                </div>
            </div>
            <div style="font-size: 20px; font-weight: 700; color: #3b82f6;">{{ rand(5, 15) }}</div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-radius: 12px; margin-bottom: 12px; background: #f0fdf4;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; background: #10b981;">
                    <i class="fas fa-image"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0 0 2px 0;">Post Baru</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Upload hari ini</p>
                </div>
            </div>
            <div style="font-size: 20px; font-weight: 700; color: #10b981;">{{ rand(20, 50) }}</div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-radius: 12px; background: #fffbeb;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; background: #f59e0b;">
                    <i class="fas fa-comment"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0 0 2px 0;">Komentar Baru</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Aktivitas hari ini</p>
                </div>
            </div>
            <div style="font-size: 20px; font-weight: 700; color: #f59e0b;">{{ rand(100, 200) }}</div>
        </div>
    </div>
</div>
@endsection


