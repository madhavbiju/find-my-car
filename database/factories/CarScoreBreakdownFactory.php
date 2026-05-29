<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarScoreBreakdown;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarScoreBreakdown>
 */
class CarScoreBreakdownFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'score_type' => fake()->randomElement(['safety_score', 'comfort_score', 'fuel_economy_score', 'value_score']),
            'reason' => fake()->randomElement(['Excellent safety rating', 'Excellent mileage', 'Spacious cabin', 'Great value for money']),
            'points' => fake()->numberBetween(50, 100),
        ];
    }
}
