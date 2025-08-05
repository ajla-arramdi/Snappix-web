<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-8">Welcome to Photo Gallery</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded">Login</a>
                <a href="{{ route('register') }}" class="bg-green-500 text-white px-6 py-2 rounded">Register</a>
            </div>
        </div>
    </div>
</body>
</html>


