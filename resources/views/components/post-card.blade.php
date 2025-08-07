<div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
    <!-- Post Header -->
    <div class="p-6 pb-4">
        <div class="flex items-center space-x-4">
            @if($post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}" 
                     alt="{{ $post->user->name }}" 
                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
            @else
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white font-bold">{{ substr($post->user->name, 0, 1) }}</span>
                </div>
            @endif
            <div class="flex-1">
                <h4 class="font-bold text-gray-900 hover:text-blue-600 transition-colors">
                    <a href="{{ route('user.show', $post->user) }}">{{ $post->user->name }}</a>
                </h4>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>
            @if(auth()->id() === $post->user_id)
                <div class="relative">
                    <button class="text-gray-400 hover:text-gray-600 p-2">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Post Image -->
    <div class="relative group">
        <img src="{{ asset('storage/' . $post->image) }}" 
             alt="{{ $post->caption }}" 
             class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
    </div>

    <!-- Post Content -->
    <div class="p-6">
        <!-- Like & Comment Buttons -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-6">
                <button onclick="toggleLike({{ $post->id }})" 
                        class="flex items-center space-x-2 hover:scale-110 transition-transform duration-200"
                        data-post-id="{{ $post->id }}">
                    <i class="fas fa-heart text-xl {{ $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-gray-600' }}"></i>
                    <span class="like-count font-medium text-gray-900">{{ $post->likeFotos->count() }}</span>
                </button>
                
                <button onclick="focusComment({{ $post->id }})" 
                        class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 hover:scale-110 transition-all duration-200">
                    <i class="fas fa-comment text-xl"></i>
                    <span class="font-medium">{{ $post->komentarFotos->count() }}</span>
                </button>
                
                <button class="text-gray-600 hover:text-green-500 hover:scale-110 transition-all duration-200">
                    <i class="fas fa-share text-xl"></i>
                </button>
            </div>
            
            <button class="text-gray-600 hover:text-yellow-500 hover:scale-110 transition-all duration-200">
                <i class="fas fa-bookmark text-xl"></i>
            </button>
        </div>

        <!-- Caption -->
        @if($post->caption)
            <div class="mb-4">
                <p class="text-gray-900">
                    <span class="font-semibold">{{ $post->user->name }}</span>
                    {{ $post->caption }}
                </p>
            </div>
        @endif

        <!-- Comments Section -->
        <div class="space-y-3">
            <!-- Show recent comments -->
            <div id="comments-{{ $post->id }}">
                @foreach($post->komentarFotos->take(3) as $comment)
                    <div class="comment-item" data-comment-id="{{ $comment->id }}">
                        <p class="text-sm text-gray-900">
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            {{ $comment->isi_komentar }}
                            @if(auth()->id() === $comment->user_id)
                                <button onclick="deleteComment({{ $comment->id }})" 
                                        class="text-red-500 hover:text-red-700 ml-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>

            @if($post->komentarFotos->count() > 3)
                <button class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    View all {{ $post->komentarFotos->count() }} comments
                </button>
            @endif

            <!-- Add Comment Form -->
            <form onsubmit="addComment(event, {{ $post->id }})" class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                <input type="text" 
                       name="isi_komentar" 
                       placeholder="Add a comment..." 
                       id="comment-input-{{ $post->id }}"
                       class="flex-1 bg-transparent border-none outline-none text-sm placeholder-gray-500"
                       required>
                <button type="submit" 
                        class="text-blue-500 hover:text-blue-600 font-semibold text-sm transition-colors">
                    Post
                </button>
            </form>
        </div>
    </div>
</div>

