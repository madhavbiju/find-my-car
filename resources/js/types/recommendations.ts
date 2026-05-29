export type RecommendationAnswers = {
    budget: string;
    usage: string;
    family_size: string;
    monthly_km: string;
    fuel_type: string;
    body_type: string;
    transmission: string;
    priority: string;
};

export type SentenceOption = {
    value: string;
    label: string;
};

export type Recommendation = {
    rank: number;
    match_percentage: number;
    make: string;
    model: string;
    variant: string;
    body_type: string;
    price: number;
    mileage: number;
    safety_rating: number;
    average_review_rating: number;
    specifications: {
        airbags: number | null;
        adas: boolean;
        boot_space_l: number | null;
        engine_cc: number | null;
        power_bhp: number | null;
        sunroof: boolean;
        fuel_type: string | null;
        transmission: string | null;
    };
    explanation: string[];
    warnings: {
        label: string;
        message: string;
    }[];
};

export type RecommendationSession = {
    id: number;
    answers: RecommendationAnswers;
    recommended_car_ids: number[];
};

export type RecommendationsLang = {
    page_titles: {
        landing: string;
        form: string;
        results: string;
    };
    landing: {
        logo: string;
        eyebrow: string;
        hero_title: string;
        hero_description: string;
        cta_button: string;
        features: Array<{ title: string; description: string }>;
    };
    form: {
        logo: string;
        step: string;
        submit_idle: string;
        submit_loading: string;
        errors_incomplete: string;
    };
    sentence: {
        part1_prefix: string;
        part1_usage_prefix: string;
        part1_family_prefix: string;
        part2_km_prefix: string;
        part2_fuel_prefix: string;
        part2_transmission_prefix: string;
        part2_transmission_suffix: string;
        part2_suffix: string;
    };
    fields: Record<keyof RecommendationAnswers, { label: string; placeholder: string }>;
    options: Record<keyof RecommendationAnswers, Record<string, string>>;
    results: {
        eyebrow: string;
        heading: string;
        subheading: string;
        refine_button: string;
        disclaimer_title: string;
        disclaimer_body: string;
        no_matches_title: string;
        no_matches_description: string;
    };
    card: {
        rank: string;
        match_label: string;
        price_label: string;
        mileage_label: string;
        mileage_unit: string;
        safety_label: string;
        safety_suffix: string;
        body_label: string;
        airbags_label: string;
        power_label: string;
        power_unit: string;
        fuel_gearbox_label: string;
        why_recommend: string;
        concerns_heading: string;
        not_specified: string;
        na: string;
    };
    warnings: Record<string, string>;
    explanations: Record<string, string>;
    breakdowns: Record<string, string>;
};
