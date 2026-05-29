<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'rating' => fake()->numberBetween(3, 5),
            'review' => fake()->sentence(),
        ];
    }
}
