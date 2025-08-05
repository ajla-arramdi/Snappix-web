@extends('layouts.admin')

@section('title', 'Pengelola User')
@section('page-title', 'Pengelola User')

@section('content')
<div class="bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Daftar User</h3>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">Total: {{ $users->total() }} users</span>
                <div class="flex items-center space-x-2">
                    <select class="text-sm border-gray-300 rounded-md" onchange="filterUsers(this.value)">
                        <option value="all">Semua User</option>
                        <option value="admin">Admin</option>
                        <option value="user">User Biasa</option>
                        <option value="banned">User Banned</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            User Info
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Role
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2"></i>
                            Bergabung
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Status
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Actions
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->hasRole('admin'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-crown mr-1"></i>
                                Admin
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-user mr-1"></i>
                                User
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_banned)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-ban mr-1"></i>
                                Banned
                            </span>
                            @if($user->banned_at)
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $user->banned_at->format('d M Y') }}
                                </div>
                            @endif
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($user->id !== auth()->id())
                            <div class="flex items-center space-x-2">
                                <!-- Ban/Unban Button -->
                                @if($user->is_banned)
                                    <form method="POST" action="{{ route('admin.unban-user', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                            <i class="fas fa-unlock mr-1"></i>
                                            Unban
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.ban-user', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition"
                                                onclick="return confirm('Yakin ingin ban user ini?')">
                                            <i class="fas fa-ban mr-1"></i>
                                            Ban
                                        </button>
                                    </form>
                                @endif

                                <!-- Role Management -->
                                @if($user->hasRole('admin'))
                                    <form method="POST" action="{{ route('admin.remove-admin', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition"
                                                onclick="return confirm('Yakin ingin hapus role admin?')">
                                            <i class="fas fa-user-minus mr-1"></i>
                                            Remove Admin
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.make-admin', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition"
                                                onclick="return confirm('Yakin ingin jadikan admin?')">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            Make Admin
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.delete-user', $user) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                                            onclick="return confirm('Yakin ingin hapus user ini? Tindakan ini tidak dapat dibatalkan!')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user-circle mr-1"></i>
                                Current User
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada user</h3>
                            <p class="text-gray-500">Belum ada user yang terdaftar di sistem.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Total Users</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-crown text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Admin Users</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Active Users</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $users->filter(fn($u) => !$u->is_banned)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-ban text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-500">Banned Users</h4>
                <p class="text-2xl font-bold text-gray-900">{{ $users->filter(fn($u) => $u->is_banned)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<script>
function filterUsers(filter) {
    // Implementasi filter nanti jika diperlukan
    console.log('Filter:', filter);
}
</script>
@endsection

