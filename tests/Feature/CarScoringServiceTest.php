<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Services\CarScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_scoring_uses_configured_thresholds_and_bonuses(): void
    {
        config([
            'recommendations.scoring.thresholds.spacious_boot_l' => 500,
            'recommendations.scoring.scores.family_spacious_boot_bonus' => 40,
            'recommendations.scoring.scores.family_standard_boot_bonus' => 5,
            'recommendations.scoring.breakdown_points.spacious_boot' => 77,
        ]);

        $car = Car::factory()->create([
            'body_type' => 'suv',
            'price' => 1500000,
            'mileage' => 18.00,
            'safety_rating' => 4.5,
            'average_review_rating' => 4.25,
        ]);

        $car->specification()->create([
            'specifications' => [
                'airbags' => 6,
                'adas' => false,
                'boot_space_l' => 520,
                'engine_cc' => 1497,
                'power_bhp' => 115,
                'sunroof' => false,
                'fuel_type' => 'petrol',
                'transmission' => 'manual',
            ],
        ]);

        $scores = app(CarScoringService::class)->calculateScores($car);

        $this->assertSame(100, $scores['family_score']);
        $this->assertDatabaseHas('car_score_breakdowns', [
            'car_id' => $car->id,
            'score_type' => 'family_score',
            'reason' => 'Spacious cabin and boot',
            'points' => 77,
        ]);
    }
}
