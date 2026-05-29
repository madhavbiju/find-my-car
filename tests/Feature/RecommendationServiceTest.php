<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_top_three_ranked_recommendations(): void
    {
        $bestCar = $this->carWithScores('Tata', 'Nexon', 1480000, 98, 80, 82);
        $secondCar = $this->carWithScores('Honda', 'City', 1420000, 92, 76, 80);
        $thirdCar = $this->carWithScores('Hyundai', 'Venue', 1310000, 88, 78, 72);
        $this->carWithScores('Maruti Suzuki', 'Baleno', 950000, 60, 92, 95);

        $result = app(RecommendationService::class)->generateRecommendations([
            'budget' => '10-15',
            'usage' => 'mixed',
            'family_size' => '3-4',
            'monthly_km' => '500-1000',
            'fuel_type' => 'petrol',
            'body_type' => 'compact-suv',
            'transmission' => 'automatic',
            'priority' => 'safety',
        ]);

        $this->assertSame($bestCar->id, $result['session']->recommended_car_ids[0]);
        $this->assertSame([$bestCar->make, $secondCar->make, $thirdCar->make], collect($result['recommendations'])->pluck('make')->all());
        $this->assertCount(3, $result['recommendations']);
    }

    public function test_it_still_returns_top_three_when_exact_matches_do_not_exist(): void
    {
        $this->carWithScores('Honda', 'City', 1640000, 94, 78, 80, 'sedan', 'petrol', 'automatic');
        $this->carWithScores('Mahindra', 'XUV700', 2675000, 98, 65, 74, 'suv', 'diesel', 'automatic');
        $this->carWithScores('Tata', 'Tiago EV', 1120000, 78, 96, 86, 'hatchback', 'electric', 'automatic');

        $result = app(RecommendationService::class)->generateRecommendations([
            'budget' => '5-10',
            'usage' => 'city',
            'family_size' => '3-4',
            'monthly_km' => '500-1000',
            'fuel_type' => 'hybrid',
            'body_type' => 'compact-suv',
            'transmission' => 'manual',
            'priority' => 'safety',
        ]);

        $this->assertCount(3, $result['recommendations']);
        $this->assertNotEmpty($result['session']->recommended_car_ids);
        $this->assertContains('Budget', collect($result['recommendations'])->flatMap(fn (array $recommendation) => collect($recommendation['warnings'])->pluck('label'))->all());
        $this->assertContains('Fuel type', collect($result['recommendations'])->flatMap(fn (array $recommendation) => collect($recommendation['warnings'])->pluck('label'))->all());
    }

    private function carWithScores(
        string $make,
        string $model,
        int $price,
        int $safety,
        int $economy,
        int $value,
        string $bodyType = 'compact-suv',
        string $fuelType = 'petrol',
        string $transmission = 'automatic',
    ): Car {
        $car = Car::factory()->create([
            'make' => $make,
            'model' => $model,
            'variant' => 'ZX AT',
            'body_type' => $bodyType,
            'price' => $price,
            'mileage' => 18.50,
            'safety_rating' => 5.0,
            'average_review_rating' => 4.5,
        ]);

        $car->specification()->create([
            'specifications' => [
                'airbags' => 6,
                'adas' => true,
                'boot_space_l' => 420,
                'engine_cc' => 1497,
                'power_bhp' => 115,
                'sunroof' => true,
                'fuel_type' => $fuelType,
                'transmission' => $transmission,
            ],
        ]);

        $car->score()->updateOrCreate(['car_id' => $car->id], [
            'family_score' => 85,
            'city_score' => 80,
            'highway_score' => 78,
            'safety_score' => $safety,
            'performance_score' => 75,
            'comfort_score' => 82,
            'fuel_economy_score' => $economy,
            'value_score' => $value,
        ]);

        $car->scoreBreakdowns()->createMany([
            ['score_type' => 'safety_score', 'reason' => 'Excellent safety rating', 'points' => $safety],
            ['score_type' => 'value_score', 'reason' => 'Great value for money', 'points' => $value],
        ]);

        return $car;
    }
}
