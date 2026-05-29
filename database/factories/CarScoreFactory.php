<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarScore>
 */
class CarScoreFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'family_score' => fake()->numberBetween(50, 100),
            'city_score' => fake()->numberBetween(50, 100),
            'highway_score' => fake()->numberBetween(50, 100),
            'safety_score' => fake()->numberBetween(50, 100),
            'performance_score' => fake()->numberBetween(50, 100),
            'comfort_score' => fake()->numberBetween(50, 100),
            'fuel_economy_score' => fake()->numberBetween(50, 100),
            'value_score' => fake()->numberBetween(50, 100),
        ];
    }
}
