<?php

return [
    // Grace bands applied to budget price bounds before filtering candidates.
    // 0.80 allows cars 20% below the lower bound (e.g. a great deal just under budget).
    // 1.15 allows cars 15% above the upper bound (on-road costs, negotiation room).
    'budget_lower_grace' => 0.80,
    'budget_upper_grace' => 1.15,

    // Weight profiles per user priority (must sum to 1.0).
    // value_score is always included as a baseline — price is the first consideration.
    'priority_weights' => [
        'safety' => ['safety_score' => 0.35, 'value_score' => 0.20, 'family_score' => 0.20, 'fuel_economy_score' => 0.15, 'performance_score' => 0.10],
        'mileage' => ['fuel_economy_score' => 0.35, 'value_score' => 0.30, 'city_score' => 0.20, 'comfort_score' => 0.15],
        'comfort' => ['comfort_score' => 0.35, 'value_score' => 0.20, 'family_score' => 0.20, 'highway_score' => 0.15, 'safety_score' => 0.10],
        'performance' => ['performance_score' => 0.35, 'value_score' => 0.20, 'highway_score' => 0.20, 'safety_score' => 0.15, 'comfort_score' => 0.10],
        'features' => ['value_score' => 0.30, 'comfort_score' => 0.25, 'safety_score' => 0.25, 'performance_score' => 0.20],
        'value' => ['value_score' => 0.40, 'fuel_economy_score' => 0.25, 'safety_score' => 0.20, 'comfort_score' => 0.15],
    ],

    // Usage-type boost: this amount is added to the relevant dimension weight, then
    // all weights are renormalised to sum to 1.0.
    'usage_boost' => [
        'city' => ['city_score' => 0.10],
        'highway' => ['highway_score' => 0.10],
        'mixed' => ['city_score' => 0.05, 'highway_score' => 0.05],
    ],

    'scoring' => [
        'defaults' => [
            'airbags' => 2,
            'boot_space_l' => 300,
            'power_bhp' => 80,
        ],

        'thresholds' => [
            'spacious_boot_l' => 400,
            'six_airbags' => 6,
            'efficient_mileage' => 18,
            'highway_power_bhp' => 110,
            'strong_power_bhp' => 150,
            'high_safety_rating' => 4.5,
        ],

        'scores' => [
            'family_base' => 45,
            'family_spacious_boot_bonus' => 25,
            'family_standard_boot_bonus' => 10,
            'family_six_airbags_bonus' => 20,
            'family_standard_airbags_bonus' => 8,
            'family_suv_bonus' => 10,

            'city_base' => 60,
            'city_compact_body_bonus' => 20,
            'city_large_body_bonus' => 5,
            'city_efficient_mileage_bonus' => 15,
            'city_standard_mileage_bonus' => 5,

            'highway_base' => 55,
            'highway_power_bonus' => 20,
            'highway_standard_power_bonus' => 8,
            'highway_spacious_boot_bonus' => 10,
            'highway_high_safety_bonus' => 15,
            'highway_standard_safety_bonus' => 5,

            'safety_rating_multiplier' => 18,
            'safety_six_airbags_bonus' => 10,
            'safety_adas_bonus' => 10,

            'performance_base' => 45,
            'performance_strong_power_bonus' => 35,
            'performance_highway_power_bonus' => 22,
            'performance_standard_power_bonus' => 8,

            'comfort_base' => 50,
            'comfort_spacious_boot_bonus' => 18,
            'comfort_standard_boot_bonus' => 8,
            'comfort_sunroof_bonus' => 12,
            'comfort_review_rating_multiplier' => 4,

            'fuel_mileage_multiplier' => 4,
            'fuel_electric_bonus' => 18,

            'value_base' => 95,
            'value_price_divisor' => 100000,
            'value_review_rating_multiplier' => 4,
        ],

        'breakdown_points' => [
            'six_airbags' => 95,
            'adas' => 92,
            'spacious_boot' => 88,
            'compact_suv' => 84,
        ],
    ],
];
