<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Snappix</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #334155;">
    <div style="display: flex; height: 100vh; overflow: hidden;">
        <!-- Sidebar -->
        <div style="width: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 4px 0 15px rgba(0,0,0,0.1); position: relative;">
            <!-- Logo Section -->
            <div style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 20px; font-weight: 700; margin: 0 0 2px 0;">Snappix</h1>
                        <p style="font-size: 12px; opacity: 0.7; margin: 0;">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- User Info -->
            <div style="padding: 16px 24px; border-bottom: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 style="font-size: 14px; font-weight: 600; margin: 0 0 2px 0;">{{ auth()->user()->name }}</h3>
                    <p style="font-size: 12px; opacity: 0.7; margin: 0;">Administrator</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav style="padding: 24px 16px;">
                <a href="{{ route('admin.dashboard') }}" 
                   style="display: flex; align-items: center; padding: 12px 16px; margin-bottom: 8px; border-radius: 12px; text-decoration: none; color: {{ request()->routeIs('admin.dashboard') ? 'white' : 'rgba(255,255,255,0.8)' }}; font-weight: 500; background: {{ request()->routeIs('admin.dashboard') ? 'rgba(255,255,255,0.2)' : 'transparent' }}; transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'; this.style.transform='translateX(4px)';"
                   onmouseout="this.style.background='{{ request()->routeIs('admin.dashboard') ? 'rgba(255,255,255,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.dashboard') ? 'white' : 'rgba(255,255,255,0.8)' }}'; this.style.transform='translateX(0)';">
                    <i class="fas fa-tachometer-alt" style="width: 20px; margin-right: 12px; font-size: 16px;"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users') }}" 
                   style="display: flex; align-items: center; padding: 12px 16px; margin-bottom: 8px; border-radius: 12px; text-decoration: none; color: {{ request()->routeIs('admin.users') ? 'white' : 'rgba(255,255,255,0.8)' }}; font-weight: 500; background: {{ request()->routeIs('admin.users') ? 'rgba(255,255,255,0.2)' : 'transparent' }}; transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'; this.style.transform='translateX(4px)';"
                   onmouseout="this.style.background='{{ request()->routeIs('admin.users') ? 'rgba(255,255,255,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.users') ? 'white' : 'rgba(255,255,255,0.8)' }}'; this.style.transform='translateX(0)';">
                    <i class="fas fa-users" style="width: 20px; margin-right: 12px; font-size: 16px;"></i>
                    Kelola User
                </a>
                
                <a href="{{ route('admin.posts') }}" 
                   style="display: flex; align-items: center; padding: 12px 16px; margin-bottom: 8px; border-radius: 12px; text-decoration: none; color: {{ request()->routeIs('admin.posts*') ? 'white' : 'rgba(255,255,255,0.8)' }}; font-weight: 500; background: {{ request()->routeIs('admin.posts*') ? 'rgba(255,255,255,0.2)' : 'transparent' }}; transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'; this.style.transform='translateX(4px)';"
                   onmouseout="this.style.background='{{ request()->routeIs('admin.posts*') ? 'rgba(255,255,255,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.posts*') ? 'white' : 'rgba(255,255,255,0.8)' }}'; this.style.transform='translateX(0)';">
                    <i class="fas fa-images" style="width: 20px; margin-right: 12px; font-size: 16px;"></i>
                    Kelola Postingan
                </a>
                
                <a href="{{ route('admin.reports') }}" 
                   style="display: flex; align-items: center; padding: 12px 16px; margin-bottom: 8px; border-radius: 12px; text-decoration: none; color: {{ request()->routeIs('admin.reports') ? 'white' : 'rgba(255,255,255,0.8)' }}; font-weight: 500; background: {{ request()->routeIs('admin.reports') ? 'rgba(255,255,255,0.2)' : 'transparent' }}; transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'; this.style.transform='translateX(4px)';"
                   onmouseout="this.style.background='{{ request()->routeIs('admin.reports') ? 'rgba(255,255,255,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.reports') ? 'white' : 'rgba(255,255,255,0.8)' }}'; this.style.transform='translateX(0)';">
                    <i class="fas fa-flag" style="width: 20px; margin-right: 12px; font-size: 16px;"></i>
                    Laporan
                </a>
            </nav>
            
            <!-- Logout Button -->
            <div style="position: absolute; bottom: 24px; left: 16px; right: 16px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: none; border-radius: 12px; color: rgba(255,255,255,0.8); font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white';"
                            onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.color='rgba(255,255,255,0.8)';">
                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
            <!-- Top Bar -->
            <header style="background: white; padding: 20px 32px; border-bottom: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">@yield('page-title', 'Dashboard')</h2>
                    <p style="color: #64748b; font-size: 14px; margin: 0;">@yield('page-description', 'Kelola sistem Snappix')</p>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 600; color: #374151;">{{ now()->format('l, d F Y') }}</div>
                        <div style="font-size: 12px; color: #6b7280;">{{ now()->format('H:i') }} WIB</div>
                    </div>
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main style="flex: 1; overflow-y: auto; padding: 32px; background: #f8fafc;">
                @if(session('success'))
                    <div style="padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 500; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534;">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 500; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[style*="background: #dcfce7"], [style*="background: #fef2f2"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>