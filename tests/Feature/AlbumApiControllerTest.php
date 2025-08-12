<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_album()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/albums', [
            'nama_album' => 'Album Baru',
            'deskripsi' => 'Deskripsi Album Baru',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('albums', [
            'nama_album' => 'Album Baru',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_view_album_list()
    {
        $user = User::factory()->create();
        Album::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/albums')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_delete_album()
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/albums/{$album->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }
}
