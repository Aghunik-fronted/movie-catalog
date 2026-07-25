<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // создаст случайного юзера
            'movie_id' => \App\Models\Movie::factory(), // создаст случайный фильм
            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->realText(200),
        ];
    }
}
