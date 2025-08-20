<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('banned'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <i class="fas fa-ban mr-2"></i>
                    Akun Anda telah dibanned dan tidak dapat mengakses sistem.
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
            </form>

            <a href="{{ route('google.login') }}" class="btn btn-danger">
    <i class="fab fa-google"></i> Login dengan Google
</a>

            <p class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-500">Don't have an account? Register</a>
            </p>
        </div>
    </div>
</body>
</html>


