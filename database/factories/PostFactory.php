<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $maxUser = User::max('id');

        return [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'author_id'   => $this->faker->numberBetween(1, $maxUser),
        ];
    }
}
