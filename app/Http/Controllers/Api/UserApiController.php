<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PostFoto;
use App\Models\Album;
use App\Models\Comment;
use App\Models\LikeFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    /**
     * Get user profile
     */
    public function profile()
    {
        $user = auth()->user()->load(['albums', 'postFotos']);
        return response()->json($user);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Get user's posts
     */
    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->postFotos()->with(['user', 'album'])->latest()->paginate(10);
        
        return response()->json($posts);
    }

    /**
     * Get user's albums
     */
    public function myAlbums()
    {
        $user = auth()->user();
        $albums = $user->albums()->with(['user', 'postFotos'])->latest()->paginate(10);
        
        return response()->json($albums);
    }

    /**
     * Get user's liked posts
     */
    public function likedPosts()
    {
        $user = auth()->user();
        $likedPosts = $user->likeFotos()->with(['postFoto.user', 'postFoto.album'])->latest()->paginate(10);
        
        return response()->json($likedPosts);
    }

    /**
     * Get user's comments
     */
    public function myComments()
    {
        $user = auth()->user();
        $comments = $user->comments()->with(['postFoto', 'user'])->latest()->paginate(10);
        
        return response()->json($comments);
    }

    /**
     * Search users
     */
    public function searchUsers(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $users = User::where('name', 'like', '%' . $validated['query'] . '%')
            ->orWhere('username', 'like', '%' . $validated['query'] . '%')
            ->where('id', '!=', auth()->id())
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Get user by username
     */
    public function getUserByUsername($username)
    {
        $user = User::where('username', $username)
            ->with(['albums', 'postFotos'])
            ->firstOrFail();

        return response()->json($user);
    }

    /**
     * Get user statistics
     */
    public function getStats()
    {
        $user = auth()->user();
        
        $stats = [
            'total_posts' => $user->postFotos()->count(),
            'total_albums' => $user->albums()->count(),
            'total_likes_received' => $user->postFotos()->withCount('likeFotos')->get()->sum('like_fotos_count'),
            'total_comments_received' => $user->postFotos()->withCount('comments')->get()->sum('comments_count'),
        ];

        return response()->json($stats);
    }

    /**
     * Delete account
     */
    public function deleteAccount(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Password is incorrect'
            ], 422);
        }

        // Delete user's posts and associated files
        foreach ($user->postFotos as $post) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        }

        // Delete user's avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully'
        ]);
    }
}
