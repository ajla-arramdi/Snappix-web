@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Pengelola User')
@section('page-description', 'Kelola Sistem Snappix')

@section('content')
<div style="padding: 32px; background: #f8fafc; min-height: 100vh;">
    <!-- Header Section -->
    <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0;">Daftar User</h2>
                <p style="color: #64748b; margin: 0;">Total: {{ $users->total() }} users terdaftar</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <select style="padding: 8px 16px; border: 1px solid #d1d5db; border-radius: 8px; background: white; color: #374151; font-size: 14px;">
                    <option value="all">Semua User</option>
                    <option value="admin">Admin</option>
                    <option value="user">User Biasa</option>
                    <option value="banned">User Banned</option>
                </select>
                <button style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 8px 16px; border-radius: 8px; border: none; font-weight: 500; cursor: pointer;">
                    <i class="fas fa-filter" style="margin-right: 8px;"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 16px 24px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">
                            <i class="fas fa-user" style="margin-right: 8px; color: #6b7280;"></i>User Info
                        </th>
                        <th style="padding: 16px 24px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">
                            <i class="fas fa-crown" style="margin-right: 8px; color: #6b7280;"></i>Role
                        </th>
                        <th style="padding: 16px 24px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">
                            <i class="fas fa-calendar" style="margin-right: 8px; color: #6b7280;"></i>Bergabung
                        </th>
                        <th style="padding: 16px 24px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">
                            <i class="fas fa-info-circle" style="margin-right: 8px; color: #6b7280;"></i>Status
                        </th>
                        <th style="padding: 16px 24px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">
                            <i class="fas fa-cogs" style="margin-right: 8px; color: #6b7280;"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s ease;" 
                        onmouseover="this.style.background='#f8fafc';" 
                        onmouseout="this.style.background='white';">
                        <!-- User Info -->
                        <td style="padding: 20px 24px;">
                            <div style="display: flex; align-items: center;">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);">
                                    <span style="color: white; font-weight: 700; font-size: 16px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h4 style="font-weight: 600; color: #1e293b; margin: 0 0 4px 0; font-size: 16px;">{{ $user->name }}</h4>
                                    <p style="color: #64748b; margin: 0; font-size: 14px;">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Role -->
                        <td style="padding: 20px 24px;">
                            @if($user->hasRole('admin'))
                                <span style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                    <i class="fas fa-crown" style="margin-right: 4px;"></i>Admin
                                </span>
                            @else
                                <span style="background: #e2e8f0; color: #64748b; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                    <i class="fas fa-user" style="margin-right: 4px;"></i>User
                                </span>
                            @endif
                        </td>

                        <!-- Join Date -->
                        <td style="padding: 20px 24px;">
                            <div style="color: #374151; font-size: 14px; font-weight: 500;">{{ $user->created_at->format('d M Y') }}</div>
                            <div style="color: #9ca3af; font-size: 12px;">{{ $user->created_at->diffForHumans() }}</div>
                        </td>

                        <!-- Status -->
                        <td style="padding: 20px 24px;">
                            @if($user->is_banned)
                                <span style="background: #fef2f2; color: #dc2626; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                    <i class="fas fa-ban" style="margin-right: 4px;"></i>Banned
                                </span>
                            @else
                                <span style="background: #dcfce7; color: #16a34a; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                    <i class="fas fa-check-circle" style="margin-right: 4px;"></i>Active
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td style="padding: 20px 24px;">
                            @if($user->id !== auth()->id())
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <!-- Ban/Unban Button -->
                                    @if($user->is_banned)
                                        <form method="POST" action="{{ route('admin.unban-user', $user) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                                    onmouseover="this.style.background='#15803d';"
                                                    onmouseout="this.style.background='#16a34a';">
                                                <i class="fas fa-unlock" style="margin-right: 4px;"></i>Unban
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.ban-user', $user) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    style="background: #dc2626; color: white; padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                                    onmouseover="this.style.background='#b91c1c';"
                                                    onmouseout="this.style.background='#dc2626';"
                                                    onclick="return confirm('Yakin ingin ban user ini?')">
                                                <i class="fas fa-ban" style="margin-right: 4px;"></i>Ban
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Role Management -->
                                    @if($user->hasRole('admin'))
                                        <form method="POST" action="{{ route('admin.remove-admin', $user) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    style="background: #f59e0b; color: white; padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                                    onmouseover="this.style.background='#d97706';"
                                                    onmouseout="this.style.background='#f59e0b';"
                                                    onclick="return confirm('Yakin ingin hapus role admin?')">
                                                <i class="fas fa-user-minus" style="margin-right: 4px;"></i>Remove Admin
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.make-admin', $user) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    style="background: #8b5cf6; color: white; padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                                    onmouseover="this.style.background='#7c3aed';"
                                                    onmouseout="this.style.background='#8b5cf6';"
                                                    onclick="return confirm('Yakin ingin jadikan admin?')">
                                                <i class="fas fa-crown" style="margin-right: 4px;"></i>Make Admin
                                            </button>
                                        </form>
                                    @endif

                                    <!-- View Detail -->
                                  
                                </div>
                            @else
                                <span style="color: #9ca3af; font-size: 12px; font-style: italic;">Current User</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 48px; text-align: center;">
                            <div style="color: #9ca3af;">
                                <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                                <h3 style="font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">Belum ada user</h3>
                                <p style="margin: 0;">User yang terdaftar akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-top: 32px;">
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #3b82f6;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-users" style="color: #3b82f6; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Total Users</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $users->total() }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #f59e0b;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-crown" style="color: #f59e0b; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Admin Users</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #16a34a;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #dcfce7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-check-circle" style="color: #16a34a; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Active Users</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $users->filter(fn($u) => !$u->is_banned)->count() }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #dc2626;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-ban" style="color: #dc2626; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Banned Users</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $users->filter(fn($u) => $u->is_banned)->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


