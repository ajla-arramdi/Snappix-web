<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Snappix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen relative">

    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ asset('image/background.png') }}" 
             alt="Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center h-full px-6">
        <div class="flex flex-col md:flex-row items-center md:items-center justify-between w-full max-w-6xl gap-12">

            <!-- Left text -->
            <div class="text-white text-3xl md:text-4xl max-w-sm text-center md:text-left font-normal">
                log in for keep <br> your memories
            </div>

            <!-- Login box -->
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-14 mb-3">
                    <h2 class="text-lg font-medium">Welcome to Snappix</h2>
                </div>

                @if(session('error'))
                    <div class="mb-3 p-2 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('banned'))
                    <div class="mb-3 p-2 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        Akun Anda telah dibanned dan tidak dapat mengakses sistem.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="Alamat email"
                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password"
                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>
                    <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium text-sm transition">
                        Masuk
                    </button>
                </form>

                <a href="{{ route('google.login') }}" 
                   class="mt-4 flex items-center justify-center gap-2 w-full bg-gray-100 border rounded-lg py-2 hover:bg-gray-200 text-sm">
                    <i class="fab fa-google text-red-500"></i> 
                    <span>Login dengan Google</span>
                </a>

                <p class="mt-4 text-center text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-red-600 font-medium">Buat akun</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>