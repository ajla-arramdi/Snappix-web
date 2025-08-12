<?php

namespace Database\Factories;

use App\Models\PostFoto;
use App\Models\User;
use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFotoFactory extends Factory
{
    protected $model = PostFoto::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'album_id' => Album::factory(),
            'caption' => $this->faker->sentence(),
            'image' => 'posts/' . $this->faker->uuid . '.jpg',
            'is_banned' => false,
        ];
    }
}
