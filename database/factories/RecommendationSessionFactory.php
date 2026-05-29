<?php

namespace Database\Factories;

use App\Models\RecommendationSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecommendationSession>
 */
class RecommendationSessionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'answers' => [
                'budget' => '10-15',
                'usage' => 'mixed',
                'family_size' => '3-4',
                'monthly_km' => '500-1000',
                'fuel_type' => 'petrol',
                'body_type' => 'compact-suv',
                'transmission' => 'automatic',
                'priority' => 'safety',
            ],
            'recommended_car_ids' => [],
        ];
    }
}
