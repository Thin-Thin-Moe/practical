<?php

namespace Database\Factories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'post_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->word(),
        ];
    }
}
