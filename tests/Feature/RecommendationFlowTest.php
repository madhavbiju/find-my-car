<?php

namespace Tests\Feature;

use App\Models\RecommendationSession;
use Database\Seeders\CarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_questionnaire_and_view_results(): void
    {
        $this->withoutVite();

        $this->seed(CarSeeder::class);

        $response = $this->post(route('recommendations.store'), [
            'budget' => '10-15',
            'usage' => 'mixed',
            'family_size' => '3-4',
            'monthly_km' => '500-1000',
            'fuel_type' => 'petrol',
            'body_type' => 'compact-suv',
            'transmission' => 'automatic',
            'priority' => 'safety',
        ]);

        $session = RecommendationSession::query()->firstOrFail();

        $response->assertRedirect(route('recommendations.show', $session));
        $this->assertNotEmpty($session->recommended_car_ids);

        $this->get(route('recommendations.show', $session))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('RecommendationResultsPage')
                ->has('recommendations', 3)
            );
    }

    public function test_questionnaire_requires_valid_enum_answers(): void
    {
        $response = $this->from(route('recommendations.create'))->post(route('recommendations.store'), [
            'budget' => 'anything',
        ]);

        $response
            ->assertRedirect(route('recommendations.create'))
            ->assertSessionHasErrors(['budget', 'usage', 'family_size', 'monthly_km', 'fuel_type', 'body_type', 'transmission', 'priority']);
    }
}
