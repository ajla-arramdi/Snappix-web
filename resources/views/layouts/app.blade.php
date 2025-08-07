<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    @yield('head')
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-camera text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Snappix</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('user.dashboard') }}" 
                           class="px-4 py-2 rounded-full font-medium {{ request()->routeIs('user.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Home
                        </a>
                        <a href="{{ route('explore') }}" 
                           class="px-4 py-2 rounded-full font-medium {{ request()->routeIs('explore') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Explore
                        </a>
                        <a href="{{ route('user.posts.create') }}" 
                           class="px-4 py-2 rounded-full font-medium text-gray-700 hover:bg-gray-100">
                            Create
                        </a>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               id="searchInput"
                               placeholder="Search users..." 
                               class="w-full pl-12 pr-4 py-3 bg-gray-100 border-none rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white"
                               autocomplete="off">
                        
                        <!-- Search Results Dropdown -->
                        <div id="searchResults" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 max-h-96 overflow-y-auto z-50 hidden">
                            <div id="searchContent" class="py-2">
                                <!-- Results will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100">
                        <i class="fas fa-bell text-lg"></i>
                    </button>
                    <button class="p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100">
                        <i class="fas fa-comment text-lg"></i>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-2 p-1 rounded-full hover:bg-gray-100 transition-colors" id="profileButton">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                     alt="Avatar" 
                                     class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50 opacity-0 invisible transform scale-95 transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('user.profile') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-3 text-gray-400"></i>
                                My Profile
                            </a>
                            
                            <a href="{{ route('user.posts.index') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-images mr-3 text-gray-400"></i>
                                My Posts
                            </a>
                            
                            <a href="{{ route('user.albums.index') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-folder mr-3 text-gray-400"></i>
                                My Albums
                            </a>
                            
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Floating Action Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="relative group">
            <!-- Main FAB -->
            <button id="fab-main" class="w-14 h-14 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-plus text-xl"></i>
            </button>
            
            <!-- Sub FABs -->
            <div id="fab-menu" class="absolute bottom-16 right-0 space-y-3 opacity-0 invisible">
                <a href="{{ route('user.posts.create') }}" 
                   class="flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full shadow-lg whitespace-nowrap">
                    <i class="fas fa-camera mr-2"></i>Create Photo
                </a>
                <a href="{{ route('user.albums.create') }}" 
                   class="flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full shadow-lg whitespace-nowrap">
                    <i class="fas fa-folder-plus mr-2"></i>Create Album
                </a>
            </div>
        </div>
    </div>

    <style>
    /* FAB Menu Animation */
    #fab-menu.show {
        opacity: 1;
        visibility: visible;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchContent = document.getElementById('searchContent');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    searchUsers(query);
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.relative.w-full')) {
                    searchResults.classList.add('hidden');
                }
            });
        }

        function searchUsers(query) {
            fetch(`/search/users?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.users);
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.classList.add('hidden');
            });
        }

        function displaySearchResults(users) {
            if (users.length === 0) {
                searchContent.innerHTML = `
                    <div class="px-4 py-3 text-center text-gray-500">
                        <i class="fas fa-search text-2xl mb-2"></i>
                        <p>No users found</p>
                    </div>
                `;
            } else {
                searchContent.innerHTML = users.map(user => `
                    <a href="/user/${user.id}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0">
                            ${user.avatar 
                                ? `<img src="/storage/${user.avatar}" alt="${user.name}" class="w-10 h-10 rounded-full object-cover">`
                                : `<div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                     <span class="text-white font-bold">${user.name.charAt(0)}</span>
                                   </div>`
                            }
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${user.name}</p>
                            <p class="text-xs text-gray-500">${user.email}</p>
                        </div>
                        <div class="text-xs text-gray-400">
                            <i class="fas fa-images mr-1"></i>${user.posts_count || 0}
                        </div>
                    </a>
                `).join('');
            }
            
            searchResults.classList.remove('hidden');
        }

        // FAB Menu Toggle
        const fabMain = document.getElementById('fab-main');
        const fabMenu = document.getElementById('fab-menu');
        let isOpen = false;

        if (fabMain && fabMenu) {
            fabMain.addEventListener('click', function() {
                if (isOpen) {
                    fabMenu.classList.remove('show');
                    fabMain.querySelector('i').style.transform = 'rotate(0deg)';
                } else {
                    fabMenu.classList.add('show');
                    fabMain.querySelector('i').style.transform = 'rotate(45deg)';
                }
                isOpen = !isOpen;
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.relative.group') && isOpen) {
                    fabMenu.classList.remove('show');
                    fabMain.querySelector('i').style.transform = 'rotate(0deg)';
                    isOpen = false;
                }
            });
        }

        // Profile Dropdown Toggle
        window.toggleDropdown = function() {
            const dropdown = document.getElementById('profileDropdown');
            const button = document.getElementById('profileButton');
            const chevron = button.querySelector('.fa-chevron-down');
            
            if (dropdown.classList.contains('opacity-0')) {
                dropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.add('opacity-100', 'visible', 'scale-100');
                chevron.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                chevron.style.transform = 'rotate(0deg)';
            }
        };

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            const button = document.getElementById('profileButton');
            
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                button.querySelector('.fa-chevron-down').style.transform = 'rotate(0deg)';
            }
        });
    });
    </script>
</body>

</html>











