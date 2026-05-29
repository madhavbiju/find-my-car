<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarSpecification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarSpecification>
 */
class CarSpecificationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'specifications' => [
                'airbags' => fake()->randomElement([2, 4, 6]),
                'adas' => fake()->boolean(30),
                'boot_space_l' => fake()->numberBetween(250, 520),
                'engine_cc' => fake()->numberBetween(999, 1999),
                'power_bhp' => fake()->numberBetween(75, 180),
                'sunroof' => fake()->boolean(40),
                'fuel_type' => fake()->randomElement(['petrol', 'diesel', 'hybrid', 'electric']),
                'transmission' => fake()->randomElement(['manual', 'automatic']),
            ],
        ];
    }
}
