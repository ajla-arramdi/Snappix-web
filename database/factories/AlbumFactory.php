<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    protected $model = Album::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'nama_album' => $this->faker->sentence(3), 
            'deskripsi' => $this->faker->optional()->paragraph(), 
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
