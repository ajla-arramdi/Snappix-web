<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Snappix</title>
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

            <!-- Register box -->
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-14 mb-3">
                    <h2 class="text-lg font-medium">Welcome to Snappix</h2>
                </div>

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <input type="text" name="name" placeholder="username" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>

		    <div>
                        <input type="email" name="email" placeholder="Alamat email" value="{{ old('email') }}"

                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>

                    <div>
                        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}"

                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>

		    <div>
                        <input type="password" name="password_confirmation" placeholder="Password Confirmation"

                               class="w-full px-3 py-2 border-2 border-red-500 rounded-xl focus:outline-none text-sm" required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium text-sm transition">
                        Register
                    </button>
                </form>

                <p class="mt-4 text-center text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-red-600 font-medium">Login</a>
                </p>

            </div>
        </div>
    </div>
</body>
</html>