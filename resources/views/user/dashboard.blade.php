@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 mb-8 text-white">
        <div class="flex items-center space-x-4">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                     alt="Avatar" 
                     class="w-16 h-16 rounded-full object-cover border-4 border-white/20">
            @else
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100">Ready to share your amazing photos?</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-plus text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Create Post</h3>
                    <p class="text-gray-600">Share your latest photo</p>
                </div>
            </div>
            <a href="{{ route('user.posts.create') }}" 
               class="mt-4 block bg-green-500 text-white text-center py-2 rounded-lg hover:bg-green-600 transition">
                Create Now
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-folder-plus text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">New Album</h3>
                    <p class="text-gray-600">Organize your photos</p>
                </div>
            </div>
            <a href="{{ route('user.albums.create') }}" 
               class="mt-4 block bg-purple-500 text-white text-center py-2 rounded-lg hover:bg-purple-600 transition">
                Create Album
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
                    <p class="text-gray-600">View and edit profile</p>
                </div>
            </div>
            <a href="{{ route('user.profile') }}" 
               class="mt-4 block bg-blue-500 text-white text-center py-2 rounded-lg hover:bg-blue-600 transition">
                View Profile
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Photos from Community</h2>
        
        <!-- Placeholder for recent photos -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @for($i = 1; $i <= 12; $i++)
                <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                </div>
            @endfor
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ route('explore') }}" 
               class="text-blue-500 hover:text-blue-600 font-medium">
                Explore More Photos →
            </a>
        </div>
    </div>
</div>
@endsection



