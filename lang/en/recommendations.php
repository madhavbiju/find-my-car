<?php

return [

    'page_titles' => [
        'landing' => 'Find My Car — Know Exactly What to Buy',
        'form' => 'Tell us how you drive',
        'results' => 'Your Shortlist is Ready',
    ],

    'landing' => [
        'logo' => 'Find My Car',
        'eyebrow' => 'No more second-guessing',
        'hero_title' => 'Know exactly which car to buy.',
        'hero_description' => 'Buying a car feels overwhelming — dozens of models, conflicting opinions, endless spec sheets. Answer a few honest questions about how you actually drive, and we\'ll score every car against your real needs. You\'ll walk away with a shortlist of 3 cars you can feel genuinely confident about.',
        'cta_button' => 'Find my car',
        'features' => [
            ['title' => 'No spec overload', 'description' => 'We ask about your life, not engine displacement. Two conversational sentences and you\'re done — no long forms, no checkbox fatigue.'],
            ['title' => 'Scored for your needs', 'description' => 'Every car is ranked against your actual budget, driving habits, family size, and top priority — not against a generic best-seller list.'],
            ['title' => 'Honest reasons, always', 'description' => 'Each pick comes with clear reasons why it fits you, and straight talk about where it doesn\'t. No surprises after you sign the papers.'],
        ],
    ],

    'form' => [
        'logo' => 'Find My Car',
        'step' => 'One quick questionnaire',
        'submit_idle' => 'Show my shortlist',
        'submit_loading' => 'Matching cars to your needs...',
        'errors_incomplete' => 'Fill in every highlighted choice — each one helps us find the right car for you.',
    ],

    'sentence' => [
        'part1_prefix' => 'My budget is around',
        'part1_usage_prefix' => ', I mainly drive',
        'part1_family_prefix' => ', and I usually travel with',
        'part2_km_prefix' => 'I cover about',
        'part2_fuel_prefix' => ', and I\'d prefer a',
        'part2_transmission_prefix' => ', with',
        'part2_transmission_suffix' => 'gears — and what matters most to me is',
        'part2_suffix' => '.',
    ],

    'fields' => [
        'budget' => ['label' => 'Budget', 'placeholder' => 'my budget range'],
        'usage' => ['label' => 'Usage', 'placeholder' => 'where I drive most'],
        'family_size' => ['label' => 'Family size', 'placeholder' => 'who rides with me'],
        'monthly_km' => ['label' => 'Monthly distance', 'placeholder' => 'how far I drive'],
        'fuel_type' => ['label' => 'Fuel type', 'placeholder' => 'fuel preference'],
        'body_type' => ['label' => 'Body style', 'placeholder' => 'body style'],
        'transmission' => ['label' => 'Gearbox', 'placeholder' => 'gearbox preference'],
        'priority' => ['label' => 'Top priority', 'placeholder' => 'what matters most'],
    ],

    'options' => [
        'budget' => [
            'under-5' => 'Under ₹5 Lakhs',
            '5-10' => '₹5 – ₹10 Lakhs',
            '10-15' => '₹10 – ₹15 Lakhs',
            '15-20' => '₹15 – ₹20 Lakhs',
            '20-30' => '₹20 – ₹30 Lakhs',
            'above-30' => 'Above ₹30 Lakhs',
        ],
        'usage' => [
            'city' => 'In the city',
            'highway' => 'On highways',
            'mixed' => 'A mix of both',
        ],
        'family_size' => [
            '1-2' => 'Just me or two',
            '3-4' => '3 to 4 of us',
            '5-plus' => '5 or more of us',
        ],
        'monthly_km' => [
            'less-than-500' => 'Under 500 km',
            '500-1000' => '500 – 1,000 km',
            '1000-2000' => '1,000 – 2,000 km',
            'more-than-2000' => 'Over 2,000 km',
        ],
        'fuel_type' => [
            'petrol' => 'Petrol',
            'diesel' => 'Diesel',
            'hybrid' => 'Hybrid',
            'electric' => 'Electric',
            'no-preference' => 'No preference',
        ],
        'body_type' => [
            'hatchback' => 'Hatchback',
            'sedan' => 'Sedan',
            'suv' => 'SUV',
            'compact-suv' => 'Compact SUV',
            'no-preference' => 'No preference',
        ],
        'transmission' => [
            'manual' => 'Manual',
            'automatic' => 'Automatic',
            'no-preference' => 'No preference',
        ],
        'priority' => [
            'safety' => 'Staying safe',
            'mileage' => 'Saving on fuel',
            'comfort' => 'A comfortable ride',
            'performance' => 'Driving thrill',
            'features' => 'Packed with features',
            'value' => 'Best value for money',
        ],
    ],

    'results' => [
        'eyebrow' => 'Picked for you',
        'heading' => 'Your top 3 matches',
        'subheading' => 'Scored against your budget, driving habits, and priorities. The higher the match, the better this car fits your life.',
        'refine_button' => 'Adjust my answers',
        'disclaimer_title' => 'Limited Data!',
        'disclaimer_body' => 'Dataset currently has only 26 models, some answer combinations might not give 3 results.',
        'no_matches_title' => 'No close matches found',
        'no_matches_description' => 'Your preferences are quite specific. Try relaxing your fuel type, body style, or transmission preference — even small changes can open up strong options.',
    ],

    'card' => [
        'rank' => 'Pick #:rank',
        'match_label' => 'Fit',
        'price_label' => 'Price',
        'mileage_label' => 'Mileage',
        'mileage_unit' => 'km/l',
        'safety_label' => 'Safety',
        'safety_suffix' => '/5',
        'body_label' => 'Body',
        'airbags_label' => 'Airbags',
        'power_label' => 'Power',
        'power_unit' => 'bhp',
        'fuel_gearbox_label' => 'Fuel & gearbox',
        'why_recommend' => 'Why this car fits you',
        'concerns_heading' => 'A few things to know',
        'not_specified' => 'Not listed',
        'na' => '—',
    ],

    'warnings' => [
        'budget_label' => 'Budget',
        'budget_below' => 'Priced below your range — may have fewer features than you expect.',
        'budget_above' => 'Stretches beyond your range — factor in the extra cost before committing.',
        'body_type_label' => 'Body style',
        'body_type_mismatch' => 'This is a :actual — you leaned towards a :expected, but it may still suit you well.',
        'fuel_type_label' => 'Fuel type',
        'fuel_type_mismatch' => 'Runs on :actual, not :expected — worth checking fuel availability and running costs.',
        'transmission_label' => 'Gearbox',
        'transmission_mismatch' => 'Comes with a :actual gearbox, not :expected — make sure you\'re comfortable with that.',
        'not_specified' => 'not listed',
    ],

    'explanations' => [
        'airbags' => ':count airbags on board',
        'adas_included' => 'Advanced driver assistance (ADAS)',
    ],

    'breakdowns' => [
        'excellent_safety' => 'Proven safety record',
        'excellent_mileage' => 'Strong fuel efficiency',
        'comfortable_cabin' => 'Comfortable for everyday journeys',
        'great_value' => 'Punches well above its price',
        'six_airbags' => '6 or more airbags for full protection',
        'adas_safety' => 'ADAS keeps you and your family safer',
        'spacious_boot' => 'Plenty of room for passengers and luggage',
        'compact_suv' => 'Compact SUV — great for city roads and weekend trips',
    ],

];
