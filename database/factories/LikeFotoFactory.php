<?php

namespace Database\Factories;

use App\Models\LikeFoto;
use App\Models\User;
use App\Models\PostFoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFotoFactory extends Factory
{
    protected $model = LikeFoto::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'post_foto_id' => PostFoto::factory(),
        ];
    }
}
