<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snappix - Photo Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    @auth
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-2">
                            <i class="fas fa-camera text-2xl text-blue-500"></i>
                            <span class="text-xl font-bold text-gray-900">Snappix</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-500 transition">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-blue-500 transition">
                                <i class="fas fa-users mr-1"></i> Users
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-blue-500 transition">
                                <i class="fas fa-home mr-1"></i> Home
                            </a>
                            <a href="{{ route('explore') }}" class="text-gray-700 hover:text-blue-500 transition">
                                <i class="fas fa-compass mr-1"></i> Explore
                            </a>
                            <a href="{{ route('user.posts.create') }}" class="text-gray-700 hover:text-blue-500 transition">
                                <i class="fas fa-plus-square mr-1"></i> Create
                            </a>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @if(!auth()->user()->hasRole('admin'))
                            <!-- Profile Avatar -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-500 transition">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                             alt="Avatar" 
                                             class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <a href="{{ route('user.posts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-images mr-2"></i> My Posts
                                    </a>
                                    <a href="{{ route('user.albums.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-folder mr-2"></i> My Albums
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @auth
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 text-center text-gray-500">
                <p>&copy; 2024 Snappix. Made with ❤️ for photo lovers.</p>
            </div>
        </footer>
    @endauth
</body>
</html>


