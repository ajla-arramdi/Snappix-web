<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\PostFoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'post_foto_id' => PostFoto::factory(),
            'isi_komentar' => $this->faker->paragraph(),
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null,
        ];
    }

    public function banned()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_banned' => true,
                'banned_at' => now(),
                'banned_by' => User::factory(),
                'ban_reason' => $this->faker->sentence(),
            ];
        });
    }
}
