<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Album;
use App\Models\PostFoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_posts()
    {
        $user = User::factory()->create();
        PostFoto::factory()->count(3)->create();

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/posts')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

     public function test_can_create_post()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $payload = [
            'judul' => 'Foto Pemandangan',
            'deskripsi' => 'Gunung di pagi hari',
            'image' => UploadedFile::fake()->image('pemandangan.jpg'),
        ];

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/posts', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['caption' => 'Foto Pemandangan']);

        Storage::disk('public')->assertExists('images/' . $payload['image']->hashName());
    }


    public function test_can_show_post()
    {
        $user = User::factory()->create();
        $post = PostFoto::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->getJson("/api/posts/{$post->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    public function test_can_delete_post()
    {
        $user = User::factory()->create();
        $post = PostFoto::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Post deleted successfully']);
    }
}