<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make' => fake()->randomElement(['Tata', 'Hyundai', 'Maruti Suzuki', 'Mahindra', 'Honda']),
            'model' => fake()->unique()->words(2, true),
            'variant' => fake()->randomElement(['VX', 'ZX', 'Alpha', 'Creative', 'AX5']),
            'body_type' => fake()->randomElement(['hatchback', 'sedan', 'suv', 'compact-suv']),
            'price' => fake()->numberBetween(600000, 2500000),
            'mileage' => fake()->randomFloat(2, 12, 24),
            'safety_rating' => fake()->randomFloat(1, 3, 5),
            'average_review_rating' => fake()->randomFloat(2, 3.5, 5),
        ];
    }
}
