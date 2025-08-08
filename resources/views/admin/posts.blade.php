@extends('layouts.admin')

@section('title', 'Kelola Postingan')
@section('page-title', 'Kelola Postingan')

@section('content')
<div style="padding: 32px; background: #f8fafc; min-height: 100vh;">
    <!-- Header Section -->
    <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0;">Daftar Postingan</h2>
                <p style="color: #64748b; margin: 0;">Total: {{ $posts->total() }} postingan</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <select style="padding: 8px 16px; border: 1px solid #d1d5db; border-radius: 8px; background: white; color: #374151; font-size: 14px;">
                    <option value="all">Semua Postingan</option>
                    <option value="active">Aktif</option>
                    <option value="banned">Dibanned</option>
                </select>
                <button style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 8px 16px; border-radius: 8px; border: none; font-weight: 500; cursor: pointer;">
                    <i class="fas fa-filter" style="margin-right: 8px;"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; margin-bottom: 32px;">
            @foreach($posts as $post)
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';" 
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
                
                <!-- Post Image -->
                <div style="position: relative; height: 240px; overflow: hidden;">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post Image" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="color: #9ca3af; font-size: 48px;"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div style="position: absolute; top: 12px; left: 12px;">
                        @if($post->is_banned ?? false)
                            <span style="background: #dc2626; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fas fa-ban" style="margin-right: 4px;"></i>Banned
                            </span>
                        @else
                            <span style="background: #16a34a; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fas fa-check" style="margin-right: 4px;"></i>Aktif
                            </span>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div style="position: absolute; top: 12px; right: 12px; display: flex; gap: 8px;">
                        <a href="{{ route('admin.post-detail', $post->id) }}" 
                           style="width: 32px; height: 32px; background: rgba(255,255,255,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #374151; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                           onmouseover="this.style.background='white';"
                           onmouseout="this.style.background='rgba(255,255,255,0.9)';">
                            <i class="fas fa-eye" style="font-size: 12px;"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.delete-post', $post) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="width: 32px; height: 32px; background: rgba(220,38,38,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                                    onmouseover="this.style.background='#dc2626';"
                                    onmouseout="this.style.background='rgba(220,38,38,0.9)';"
                                    onclick="return confirm('Yakin ingin hapus postingan ini?')">
                                <i class="fas fa-trash" style="font-size: 12px;"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Post Content -->
                <div style="padding: 20px;">
                    <!-- User Info -->
                    <div style="display: flex; align-items: center; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                            <span style="color: white; font-weight: 700; font-size: 14px;">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-weight: 600; color: #1e293b; margin: 0 0 2px 0; font-size: 14px;">{{ $post->user->name }}</h4>
                            <p style="color: #64748b; margin: 0; font-size: 12px;">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Caption -->
                    @if($post->caption)
                        <p style="color: #374151; margin: 0 0 16px 0; font-size: 14px; line-height: 1.5;">{{ Str::limit($post->caption, 80) }}</p>
                    @endif

                    <!-- Stats -->
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding: 12px; background: #f8fafc; border-radius: 8px;">
                        <div style="display: flex; gap: 16px;">
                            <span style="display: flex; align-items: center; color: #64748b; font-size: 13px;">
                                <i class="fas fa-heart" style="color: #ef4444; margin-right: 6px;"></i>
                                {{ $post->likeFotos->count() }}
                            </span>
                            <span style="display: flex; align-items: center; color: #64748b; font-size: 13px;">
                                <i class="fas fa-comment" style="color: #3b82f6; margin-right: 6px;"></i>
                                {{ $post->komentarFotos->count() }}
                            </span>
                        </div>
                        <span style="color: #9ca3af; font-size: 12px;">{{ $post->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 8px;">
                        @if($post->is_banned ?? false)
                            <form method="POST" action="{{ route('admin.unban-post', $post) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" 
                                        style="width: 100%; background: #16a34a; color: white; padding: 8px 16px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#15803d';"
                                        onmouseout="this.style.background='#16a34a';">
                                    <i class="fas fa-unlock" style="margin-right: 6px;"></i>Unban
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.ban-post', $post) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" 
                                        style="width: 100%; background: #dc2626; color: white; padding: 8px 16px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#b91c1c';"
                                        onmouseout="this.style.background='#dc2626';"
                                        onclick="return confirm('Ban postingan ini?')">
                                    <i class="fas fa-ban" style="margin-right: 6px;"></i>Ban
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.post-detail', $post->id) }}" 
                           style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center;"
                           onmouseover="this.style.background='#2563eb';"
                           onmouseout="this.style.background='#3b82f6';">
                            <i class="fas fa-eye" style="margin-right: 6px;"></i>Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div style="display: flex; justify-content: center; margin-top: 32px;">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div style="background: white; border-radius: 16px; padding: 48px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px auto;">
                <i class="fas fa-images" style="color: #9ca3af; font-size: 32px;"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 600; color: #1e293b; margin: 0 0 8px 0;">Belum ada postingan</h3>
            <p style="color: #64748b; margin: 0;">Postingan dari pengguna akan muncul di sini</p>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-top: 32px;">
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #3b82f6;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-images" style="color: #3b82f6; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Total Posts</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $posts->total() }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #ef4444;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-heart" style="color: #ef4444; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Total Likes</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $posts->sum(fn($p) => $p->likeFotos->count()) }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #8b5cf6;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #f3e8ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-comment" style="color: #8b5cf6; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">Total Comments</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $posts->sum(fn($p) => $p->komentarFotos->count()) }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #f59e0b;">
            <div style="display: flex; align-items: center;">
                <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-calendar" style="color: #f59e0b; font-size: 20px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #64748b; font-weight: 500; margin: 0 0 4px 0;">This Month</h4>
                    <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $posts->filter(fn($p) => $p->created_at->isCurrentMonth())->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
