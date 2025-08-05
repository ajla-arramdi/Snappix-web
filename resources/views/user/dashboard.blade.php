<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold">Photo Gallery</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span>Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="max-w-7xl mx-auto py-6 px-4">
            <h2 class="text-2xl font-bold mb-6">User Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-bold mb-2">My Photos</h3>
                    <p class="text-gray-600">Manage your photos</p>
                    <a href="{{ route('user.photos') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">View Photos</a>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-bold mb-2">My Albums</h3>
                    <p class="text-gray-600">Organize your photos</p>
                    <a href="{{ route('user.albums') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">View Albums</a>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-bold mb-2">Profile</h3>
                    <p class="text-gray-600">Update your profile</p>
                    <a href="{{ route('user.profile') }}" class="mt-4 inline-block bg-purple-500 text-white px-4 py-2 rounded">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

