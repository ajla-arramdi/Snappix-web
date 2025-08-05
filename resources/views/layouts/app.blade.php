<!DOCTYPE html>
<html>
<head>
    <title>Instagram App</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f5f5f5; }
        .navbar { background: #007bff; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 800px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; }
        .auth-container { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button, .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        .error { color: red; font-size: 14px; }
        .success { color: green; font-size: 14px; padding: 10px; background: #d4edda; border-radius: 4px; margin-bottom: 15px; }
        .link { color: #007bff; text-decoration: none; }
        .demo { background: #f8f9fa; padding: 15px; margin-top: 20px; border-radius: 4px; }
        .card { background: #f8f9fa; padding: 20px; margin: 10px 0; border-radius: 4px; }
        .stats { display: flex; gap: 20px; margin: 20px 0; }
        .stat-card { background: #007bff; color: white; padding: 20px; border-radius: 4px; text-align: center; flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    @auth
        <div class="navbar">
            <div>
                <strong>Instagram App</strong>
                <span style="margin-left: 20px;">{{ auth()->user()->name }}</span>
            </div>
            <div>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.users') }}">Users</a>
                @else
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    <a href="{{ route('user.profile') }}">Profile</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: #dc3545; margin-left: 10px;">Logout</button>
                </form>
            </div>
        </div>
    @endauth

    <div class="{{ auth()->check() ? 'container' : 'auth-container' }}">
        @yield('content')
    </div>
</body>
</html>
