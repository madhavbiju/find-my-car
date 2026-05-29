<?php

namespace App\Services;

use App\Models\Car;

class CarScoringService
{
    /**
     * @return array<string, int>
     */
    public function calculateScores(Car $car): array
    {
        $car->loadMissing('specification');

        $defaults = $this->scoringConfig('defaults');
        $thresholds = $this->scoringConfig('thresholds');
        $scoresConfig = $this->scoringConfig('scores');
        $specifications = $car->specification?->specifications ?? [];
        $airbags = (int) ($specifications['airbags'] ?? $defaults['airbags']);
        $bootSpace = (int) ($specifications['boot_space_l'] ?? $defaults['boot_space_l']);
        $power = (int) ($specifications['power_bhp'] ?? $defaults['power_bhp']);
        $hasAdas = (bool) ($specifications['adas'] ?? false);
        $hasSunroof = (bool) ($specifications['sunroof'] ?? false);
        $isCompactBody = $car->body_type === 'hatchback' || $car->body_type === 'compact-suv';

        $scores = [
            'family_score' => $this->clamp($scoresConfig['family_base'] + ($bootSpace >= $thresholds['spacious_boot_l'] ? $scoresConfig['family_spacious_boot_bonus'] : $scoresConfig['family_standard_boot_bonus']) + ($airbags >= $thresholds['six_airbags'] ? $scoresConfig['family_six_airbags_bonus'] : $scoresConfig['family_standard_airbags_bonus']) + ($car->body_type === 'suv' ? $scoresConfig['family_suv_bonus'] : 0)),
            'city_score' => $this->clamp($scoresConfig['city_base'] + ($isCompactBody ? $scoresConfig['city_compact_body_bonus'] : $scoresConfig['city_large_body_bonus']) + ((float) $car->mileage >= $thresholds['efficient_mileage'] ? $scoresConfig['city_efficient_mileage_bonus'] : $scoresConfig['city_standard_mileage_bonus'])),
            'highway_score' => $this->clamp($scoresConfig['highway_base'] + ($power >= $thresholds['highway_power_bhp'] ? $scoresConfig['highway_power_bonus'] : $scoresConfig['highway_standard_power_bonus']) + ($bootSpace >= $thresholds['spacious_boot_l'] ? $scoresConfig['highway_spacious_boot_bonus'] : 0) + ($car->safety_rating >= $thresholds['high_safety_rating'] ? $scoresConfig['highway_high_safety_bonus'] : $scoresConfig['highway_standard_safety_bonus'])),
            'safety_score' => $this->clamp(((float) $car->safety_rating * $scoresConfig['safety_rating_multiplier']) + ($airbags >= $thresholds['six_airbags'] ? $scoresConfig['safety_six_airbags_bonus'] : 0) + ($hasAdas ? $scoresConfig['safety_adas_bonus'] : 0)),
            'performance_score' => $this->clamp($scoresConfig['performance_base'] + ($power >= $thresholds['strong_power_bhp'] ? $scoresConfig['performance_strong_power_bonus'] : ($power >= $thresholds['highway_power_bhp'] ? $scoresConfig['performance_highway_power_bonus'] : $scoresConfig['performance_standard_power_bonus']))),
            'comfort_score' => $this->clamp($scoresConfig['comfort_base'] + ($bootSpace >= $thresholds['spacious_boot_l'] ? $scoresConfig['comfort_spacious_boot_bonus'] : $scoresConfig['comfort_standard_boot_bonus']) + ($hasSunroof ? $scoresConfig['comfort_sunroof_bonus'] : 0) + ((float) $car->average_review_rating * $scoresConfig['comfort_review_rating_multiplier'])),
            'fuel_economy_score' => $this->clamp(((float) $car->mileage * $scoresConfig['fuel_mileage_multiplier']) + (($specifications['fuel_type'] ?? null) === 'electric' ? $scoresConfig['fuel_electric_bonus'] : 0)),
            'value_score' => $this->clamp($scoresConfig['value_base'] - ((float) $car->price / $scoresConfig['value_price_divisor']) + ((float) $car->average_review_rating * $scoresConfig['value_review_rating_multiplier'])),
        ];

        $car->score()->updateOrCreate(['car_id' => $car->id], $scores);

        $car->scoreBreakdowns()->delete();
        $car->scoreBreakdowns()->createMany($this->buildBreakdowns($car, $specifications, $scores));

        return $scores;
    }

    private function clamp(float|int $value): int
    {
        return (int) max(0, min(100, round($value)));
    }

    /**
     * @return array<string, int|float>
     */
    private function scoringConfig(string $key): array
    {
        return config("recommendations.scoring.{$key}", []);
    }

    /**
     * @param  array<string, mixed>  $specifications
     * @param  array<string, int>  $scores
     * @return array<int, array{score_type: string, reason: string, points: int}>
     */
    private function buildBreakdowns(Car $car, array $specifications, array $scores): array
    {
        $thresholds = $this->scoringConfig('thresholds');
        $breakdownPoints = $this->scoringConfig('breakdown_points');

        $breakdowns = [
            ['score_type' => 'safety_score', 'reason' => __('recommendations.breakdowns.excellent_safety'), 'points' => $scores['safety_score']],
            ['score_type' => 'fuel_economy_score', 'reason' => __('recommendations.breakdowns.excellent_mileage'), 'points' => $scores['fuel_economy_score']],
            ['score_type' => 'comfort_score', 'reason' => __('recommendations.breakdowns.comfortable_cabin'), 'points' => $scores['comfort_score']],
            ['score_type' => 'value_score', 'reason' => __('recommendations.breakdowns.great_value'), 'points' => $scores['value_score']],
        ];

        if (($specifications['airbags'] ?? 0) >= $thresholds['six_airbags']) {
            $breakdowns[] = ['score_type' => 'safety_score', 'reason' => __('recommendations.breakdowns.six_airbags'), 'points' => $breakdownPoints['six_airbags']];
        }

        if (($specifications['adas'] ?? false) === true) {
            $breakdowns[] = ['score_type' => 'safety_score', 'reason' => __('recommendations.breakdowns.adas_safety'), 'points' => $breakdownPoints['adas']];
        }

        if (($specifications['boot_space_l'] ?? 0) >= $thresholds['spacious_boot_l']) {
            $breakdowns[] = ['score_type' => 'family_score', 'reason' => __('recommendations.breakdowns.spacious_boot'), 'points' => $breakdownPoints['spacious_boot']];
        }

        if ($car->body_type === 'compact-suv') {
            $breakdowns[] = ['score_type' => 'city_score', 'reason' => __('recommendations.breakdowns.compact_suv'), 'points' => $breakdownPoints['compact_suv']];
        }

        return $breakdowns;
    }
}
