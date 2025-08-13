<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Album;
use App\Models\PostFoto;
use App\Models\Comment;
use App\Models\LikeFoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_get_user_profile()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/profile');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'name', 'email', 'username', 'albums', 'post_fotos'
            ]);
    }

    public function test_can_update_user_profile()
    {
        $updateData = [
            'name' => 'Updated Name',
            'username' => 'updated_username',
            'bio' => 'This is my bio'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson('/api/user/profile', $updateData)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Profile updated successfully'])
            ->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_can_update_user_profile_with_avatar()
    {
        Storage::fake('public');
        
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        
        $updateData = [
            'name' => 'Updated Name',
            'avatar' => $avatar
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson('/api/user/profile', $updateData)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Profile updated successfully']);

        Storage::disk('public')->assertExists('avatars/' . $avatar->hashName());
    }

    public function test_cannot_update_email_to_existing_one()
    {
        $otherUser = User::factory()->create(['email' => 'existing@example.com']);

        $updateData = [
            'email' => 'existing@example.com'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson('/api/user/profile', $updateData)
            ->assertStatus(422);
    }

    public function test_can_change_password()
    {
        $passwordData = [
            'current_password' => 'password',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson('/api/user/change-password', $passwordData)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Password changed successfully']);
    }

    public function test_cannot_change_password_with_wrong_current_password()
    {
        $passwordData = [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson('/api/user/change-password', $passwordData)
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'Current password is incorrect']);
    }

    public function test_can_get_my_posts()
    {
        PostFoto::factory()->count(3)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/my-posts')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_my_albums()
    {
        Album::factory()->count(2)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/my-albums')
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_can_get_liked_posts()
    {
        $post = PostFoto::factory()->create();
        LikeFoto::factory()->create([
            'user_id' => $this->user->id,
            'post_foto_id' => $post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/liked-posts')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_get_my_comments()
    {
        $post = PostFoto::factory()->create();
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_foto_id' => $post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/my-comments')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_search_users()
    {
        User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/search?query=John')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_get_user_by_username()
    {
        $targetUser = User::factory()->create(['username' => 'testuser']);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/username/testuser')
            ->assertStatus(200)
            ->assertJsonFragment(['username' => 'testuser']);
    }

    public function test_can_get_user_stats()
    {
        PostFoto::factory()->count(2)->create(['user_id' => $this->user->id]);
        Album::factory()->count(1)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/user/stats')
            ->assertStatus(200)
            ->assertJsonFragment([
                'total_posts' => 2,
                'total_albums' => 1
            ]);
    }

    public function test_can_delete_account()
    {
        $passwordData = [
            'password' => 'password'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->deleteJson('/api/user/delete-account', $passwordData)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Account deleted successfully']);
    }

    public function test_cannot_delete_account_with_wrong_password()
    {
        $passwordData = [
            'password' => 'wrongpassword'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->deleteJson('/api/user/delete-account', $passwordData)
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'Password is incorrect']);
    }
}
