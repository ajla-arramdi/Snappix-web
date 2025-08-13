<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PostFoto;
use App\Models\Comment;
use App\Models\LikeFoto;
use App\Models\ReportPost;
use App\Models\ReportComment;
use App\Models\ReportUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = PostFoto::factory()->create();
    }

    public function test_can_like_post()
    {
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/like")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Post liked successfully'])
            ->assertJsonStructure(['message', 'likes_count']);

        $this->assertDatabaseHas('like_fotos', [
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id
        ]);
    }

    public function test_cannot_like_already_liked_post()
    {
        // Like first time
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/like");

        // Try to like again
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/like")
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'Post already liked']);
    }

    public function test_can_unlike_post()
    {
        // Like first
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/like");

        // Then unlike
        $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/social/posts/{$this->post->id}/unlike")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Post unliked successfully']);

        $this->assertDatabaseMissing('like_fotos', [
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id
        ]);
    }

    public function test_cannot_unlike_not_liked_post()
    {
        $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/social/posts/{$this->post->id}/unlike")
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'Post not liked']);
    }

    public function test_can_add_comment_to_post()
    {
        $commentData = [
            'isi_komentar' => 'This is a great photo!'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/comments", $commentData)
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Comment added successfully'])
            ->assertJsonStructure(['message', 'comment']);

        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id,
            'isi_komentar' => 'This is a great photo!'
        ]);
    }

    public function test_cannot_add_comment_without_content()
    {
        $commentData = [];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/comments", $commentData)
            ->assertStatus(422);
    }

    public function test_can_update_comment()
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id
        ]);

        $updateData = [
            'isi_komentar' => 'Updated comment content'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/social/comments/{$comment->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Comment updated successfully'])
            ->assertJsonFragment(['isi_komentar' => 'Updated comment content']);
    }

    public function test_cannot_update_other_users_comment()
    {
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'post_foto_id' => $this->post->id
        ]);

        $updateData = [
            'isi_komentar' => 'Updated comment content'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/social/comments/{$comment->id}", $updateData)
            ->assertStatus(403)
            ->assertJsonFragment(['message' => 'You can only update your own comments']);
    }

    public function test_can_delete_own_comment()
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/social/comments/{$comment->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Comment deleted successfully']);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_can_report_post()
    {
        $reportData = [
            'alasan' => 'Inappropriate content',
            'deskripsi' => 'This post contains inappropriate content'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/report", $reportData)
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Post reported successfully']);

        $this->assertDatabaseHas('report_posts', [
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id,
            'alasan' => 'Inappropriate content'
        ]);
    }

    public function test_cannot_report_post_twice()
    {
        $reportData = [
            'alasan' => 'Inappropriate content',
            'deskripsi' => 'This post contains inappropriate content'
        ];

        // Report first time
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/report", $reportData);

        // Try to report again
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/{$this->post->id}/report", $reportData)
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'Post already reported']);
    }

    public function test_can_report_comment()
    {
        $comment = Comment::factory()->create();
        
        $reportData = [
            'alasan' => 'Spam',
            'deskripsi' => 'This comment is spam'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/comments/{$comment->id}/report", $reportData)
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Comment reported successfully']);

        $this->assertDatabaseHas('report_comments', [
            'user_id' => $this->user->id,
            'comment_id' => $comment->id,
            'alasan' => 'Spam'
        ]);
    }

    public function test_can_report_user()
    {
        $reportedUser = User::factory()->create();
        
        $reportData = [
            'alasan' => 'Harassment',
            'deskripsi' => 'This user is harassing others'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/users/{$reportedUser->id}/report", $reportData)
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'User reported successfully']);

        $this->assertDatabaseHas('report_users', [
            'reporter_id' => $this->user->id,
            'reported_user_id' => $reportedUser->id,
            'alasan' => 'Harassment'
        ]);
    }

    public function test_cannot_report_yourself()
    {
        $reportData = [
            'alasan' => 'Harassment',
            'deskripsi' => 'This user is harassing others'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/users/{$this->user->id}/report", $reportData)
            ->assertStatus(422)
            ->assertJsonFragment(['message' => 'You cannot report yourself']);
    }

    public function test_can_get_post_comments()
    {
        Comment::factory()->count(3)->create([
            'post_foto_id' => $this->post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/social/posts/{$this->post->id}/comments")
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_post_likes()
    {
        LikeFoto::factory()->count(2)->create([
            'post_foto_id' => $this->post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/social/posts/{$this->post->id}/likes")
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_can_check_like_status()
    {
        $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/social/posts/{$this->post->id}/like-status")
            ->assertStatus(200)
            ->assertJsonStructure(['is_liked', 'likes_count'])
            ->assertJsonFragment(['is_liked' => false]);
    }

    public function test_can_check_like_status_when_liked()
    {
        // Like the post first
        LikeFoto::factory()->create([
            'user_id' => $this->user->id,
            'post_foto_id' => $this->post->id
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/social/posts/{$this->post->id}/like-status")
            ->assertStatus(200)
            ->assertJsonFragment(['is_liked' => true]);
    }

    public function test_cannot_add_comment_to_nonexistent_post()
    {
        $commentData = [
            'isi_komentar' => 'This is a comment'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/999/comments", $commentData)
            ->assertStatus(404);
    }

    public function test_cannot_like_nonexistent_post()
    {
        $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/social/posts/999/like")
            ->assertStatus(404);
    }

    public function test_cannot_update_nonexistent_comment()
    {
        $updateData = [
            'isi_komentar' => 'Updated content'
        ];

        $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/social/comments/999", $updateData)
            ->assertStatus(404);
    }

    public function test_cannot_delete_nonexistent_comment()
    {
        $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/social/comments/999")
            ->assertStatus(404);
    }
}
