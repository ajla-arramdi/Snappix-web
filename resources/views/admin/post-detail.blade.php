@extends('layouts.admin')

@section('title', 'Detail Postingan')
@section('page-title', 'Detail Postingan')

@section('content')
<div style="padding: 32px; background: #f8fafc; min-height: 100vh;">
    <!-- Back Button -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.posts') }}" 
           style="display: inline-flex; align-items: center; background: white; color: #374151; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s ease;"
           onmouseover="this.style.background='#f9fafb';"
           onmouseout="this.style.background='white';">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Kembali ke Daftar Postingan
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Post Detail -->
        <div>
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden;">
                <!-- Post Header -->
                <div style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <span style="color: white; font-weight: 700; font-size: 16px;">
                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0 0 4px 0;">{{ $post->user->name }}</h3>
                                <p style="color: #64748b; margin: 0; font-size: 14px;">{{ $post->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($post->is_banned)
                            <span style="display: inline-flex; align-items: center; background: #fef2f2; color: #dc2626; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                                <i class="fas fa-ban" style="margin-right: 8px;"></i>Banned
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; background: #dcfce7; color: #16a34a; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Active
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Post Image -->
                <div style="padding: 24px;">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post Image" 
                             style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    @else
                        <div style="width: 100%; height: 300px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="color: #9ca3af; font-size: 64px;"></i>
                        </div>
                    @endif
                </div>

                <!-- Post Caption -->
                @if($post->caption)
                <div style="padding: 0 24px 24px 24px; border-bottom: 1px solid #e2e8f0;">
                    <p style="color: #374151; margin: 0; font-size: 16px; line-height: 1.6;">{{ $post->caption }}</p>
                </div>
                @endif

                <!-- Post Stats -->
                <div style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 32px;">
                        <div style="display: flex; align-items: center; color: #64748b;">
                            <i class="fas fa-heart" style="color: #ef4444; margin-right: 8px; font-size: 18px;"></i>
                            <span style="font-weight: 600; font-size: 16px;">{{ $post->likeFotos->count() }} likes</span>
                        </div>
                        <div style="display: flex; align-items: center; color: #64748b;">
                            <i class="fas fa-comment" style="color: #3b82f6; margin-right: 8px; font-size: 18px;"></i>
                            <span style="font-weight: 600; font-size: 16px;">{{ $post->komentarFotos->count() }} komentar</span>
                        </div>
                    </div>
                </div>

                <!-- Post Actions -->
                <div style="padding: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($post->is_banned)
                            <form method="POST" action="{{ route('admin.unban-post', $post) }}" style="display: inline;">
                                @csrf
                                <button type="submit" 
                                        style="display: inline-flex; align-items: center; background: #16a34a; color: white; padding: 12px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#15803d';"
                                        onmouseout="this.style.background='#16a34a';">
                                    <i class="fas fa-unlock" style="margin-right: 8px;"></i>Unban Post
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.ban-post', $post) }}" style="display: inline;">
                                @csrf
                                <button type="submit" 
                                        style="display: inline-flex; align-items: center; background: #f59e0b; color: white; padding: 12px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#d97706';"
                                        onmouseout="this.style.background='#f59e0b';"
                                        onclick="return confirm('Yakin ingin ban postingan ini?')">
                                    <i class="fas fa-ban" style="margin-right: 8px;"></i>Ban Post
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.delete-post', $post) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="display: inline-flex; align-items: center; background: #dc2626; color: white; padding: 12px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s ease;"
                                    onmouseover="this.style.background='#b91c1c';"
                                    onmouseout="this.style.background='#dc2626';"
                                    onclick="return confirm('Yakin ingin hapus postingan ini?')">
                                <i class="fas fa-trash" style="margin-right: 8px;"></i>Delete Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Comments Section -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0;">
                        Komentar ({{ $post->komentarFotos->count() }})
                    </h3>
                </div>

                <div style="max-height: 400px; overflow-y: auto;">
                    @forelse($post->komentarFotos as $comment)
                    <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: start; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #16a34a, #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <span style="color: white; font-weight: 600; font-size: 12px;">
                                    {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                    <p style="font-weight: 600; color: #1e293b; margin: 0; font-size: 14px;">{{ $comment->user->name }}</p>
                                    <p style="color: #9ca3af; margin: 0; font-size: 12px;">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                <p style="color: #374151; margin: 0 0 8px 0; font-size: 14px; line-height: 1.4;">{{ $comment->isi_komentar }}</p>
                                
                                <form method="POST" action="{{ route('admin.delete-comment', $comment) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="color: #dc2626; background: none; border: none; font-size: 12px; cursor: pointer; padding: 0; text-decoration: underline;"
                                            onclick="return confirm('Yakin ingin hapus komentar ini?')">
                                        <i class="fas fa-trash" style="margin-right: 4px;"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="padding: 32px 20px; text-align: center;">
                        <i class="fas fa-comments" style="color: #9ca3af; font-size: 32px; margin-bottom: 12px; display: block;"></i>
                        <p style="color: #64748b; margin: 0;">Belum ada komentar</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Likes Section -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0;">
                        Likes ({{ $post->likeFotos->count() }})
                    </h3>
                </div>

                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse($post->likeFotos as $like)
                    <div style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #ef4444, #f97316); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span style="color: white; font-weight: 600; font-size: 12px;">
                                    {{ strtoupper(substr($like->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div style="flex: 1;">
                                <p style="font-weight: 600; color: #1e293b; margin: 0; font-size: 14px;">{{ $like->user->name }}</p>
                                <p style="color: #9ca3af; margin: 0; font-size: 12px;">{{ $like->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="padding: 32px 20px; text-align: center;">
                        <i class="fas fa-heart" style="color: #9ca3af; font-size: 32px; margin-bottom: 12px; display: block;"></i>
                        <p style="color: #64748b; margin: 0;">Belum ada yang like</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
