<?php

namespace App\Services;

use App\Enums\BodyType;
use App\Enums\BudgetRange;
use App\Enums\FuelType;
use App\Enums\Transmission;
use App\Enums\UserPriority;
use App\Models\Car;
use App\Models\RecommendationSession;
use App\Repositories\CarRepository;
use App\Repositories\RecommendationSessionRepository;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function __construct(
        private CarRepository $cars,
        private RecommendationSessionRepository $sessions,
    ) {}

    /**
     * @param  array<string, string>  $answers
     * @return array{session: RecommendationSession, recommendations: array<int, array<string, mixed>>}
     */
    public function generateRecommendations(array $answers): array
    {
        $weights = $this->buildWeights($answers);

        $recommendations = $this->cars
            ->getRecommendationCandidates($answers)
            ->map(fn (Car $car): array => [
                'car' => $car,
                'match_percentage' => $this->calculateScore($car, $weights, $answers),
                'explanation' => $this->buildExplanation($car),
                'warnings' => $this->buildFitWarnings($car, $answers),
            ])
            ->sortByDesc('match_percentage')
            ->take(3)
            ->values();

        $session = $this->sessions->create([
            'answers' => $answers,
            'recommended_car_ids' => $recommendations->pluck('car.id')->all(),
        ]);

        return [
            'session' => $session,
            'recommendations' => $this->serializeRecommendations($recommendations),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecommendationsForSession(RecommendationSession $session): array
    {
        $weights = $this->buildWeights($session->answers ?? []);
        $carIds = $session->recommended_car_ids ?? [];

        $recommendations = $this->cars
            ->findManyByIds($carIds)
            ->map(fn (Car $car): array => [
                'car' => $car,
                'match_percentage' => $this->calculateScore($car, $weights, $session->answers ?? []),
                'explanation' => $this->buildExplanation($car),
                'warnings' => $this->buildFitWarnings($car, $session->answers ?? []),
            ]);

        return $this->serializeRecommendations($recommendations);
    }

    /**
     * @param  array<string, float>  $weights
     * @param  array<string, string>  $answers
     */
    public function calculateScore(Car $car, array $weights, array $answers = []): int
    {
        $score = $car->score;

        if (! $score) {
            return 0;
        }

        $weightedScore = collect($weights)->sum(fn (float $weight, string $dimension): float => ((int) $score->{$dimension}) * $weight);

        $penalty = collect($this->buildFitWarnings($car, $answers))->sum(fn (array $warning): int => $warning['penalty']);

        return (int) max(1, min(100, round($weightedScore - $penalty)));
    }

    /**
     * @return array<int, string>
     */
    public function buildExplanation(Car $car): array
    {
        $specifications = $car->specification?->specifications ?? [];

        return $car->scoreBreakdowns
            ->sortByDesc('points')
            ->pluck('reason')
            ->when(
                ($specifications['airbags'] ?? 0) >= 6,
                fn (Collection $reasons) => $reasons->prepend(__('recommendations.explanations.airbags', ['count' => $specifications['airbags']]))
            )
            ->when(
                (bool) ($specifications['adas'] ?? false),
                fn (Collection $reasons) => $reasons->prepend(__('recommendations.explanations.adas_included'))
            )
            ->unique()
            ->take(5)
            ->values()
            ->all();
    }

    /**
     * @param  array<string, string>  $answers
     * @return array<int, array{label: string, message: string, penalty: int}>
     */
    public function buildFitWarnings(Car $car, array $answers): array
    {
        $warnings = [];
        $specifications = $car->specification?->specifications ?? [];

        if ($budget = BudgetRange::tryFrom($answers['budget'] ?? '')) {
            [$minimum, $maximum] = $budget->priceBounds();

            if ($minimum !== null && (float) $car->price < $minimum) {
                $warnings[] = [
                    'label' => __('recommendations.warnings.budget_label'),
                    'message' => __('recommendations.warnings.budget_below'),
                    'penalty' => 4,
                ];
            }

            if ($maximum !== null && (float) $car->price > $maximum) {
                $warnings[] = [
                    'label' => __('recommendations.warnings.budget_label'),
                    'message' => __('recommendations.warnings.budget_above'),
                    'penalty' => 25,
                ];
            }
        }

        if (($bodyType = BodyType::tryFrom($answers['body_type'] ?? '')) && $bodyType !== BodyType::NoPreference && $car->body_type !== $bodyType->value) {
            $warnings[] = [
                'label' => __('recommendations.warnings.body_type_label'),
                'message' => __('recommendations.warnings.body_type_mismatch', ['actual' => $this->displayValue($car->body_type), 'expected' => $this->displayValue($bodyType->value)]),
                'penalty' => 8,
            ];
        }

        $fuelType = FuelType::tryFrom($answers['fuel_type'] ?? '');
        $carFuelType = $specifications['fuel_type'] ?? null;

        if ($fuelType && $fuelType !== FuelType::NoPreference && $carFuelType !== $fuelType->value) {
            $warnings[] = [
                'label' => __('recommendations.warnings.fuel_type_label'),
                'message' => __('recommendations.warnings.fuel_type_mismatch', ['actual' => $this->displayValue($carFuelType), 'expected' => $this->displayValue($fuelType->value)]),
                'penalty' => 8,
            ];
        }

        $transmission = Transmission::tryFrom($answers['transmission'] ?? '');
        $carTransmission = $specifications['transmission'] ?? null;

        if ($transmission && $transmission !== Transmission::NoPreference && $carTransmission !== $transmission->value) {
            $warnings[] = [
                'label' => __('recommendations.warnings.transmission_label'),
                'message' => __('recommendations.warnings.transmission_mismatch', ['actual' => $this->displayValue($carTransmission), 'expected' => $this->displayValue($transmission->value)]),
                'penalty' => 8,
            ];
        }

        return $warnings;
    }

    /**
     * @param  array<string, string>  $answers
     * @return array<string, float>
     */
    private function buildWeights(array $answers): array
    {
        $priority = UserPriority::tryFrom($answers['priority'] ?? '') ?? UserPriority::Value;

        /** @var array<string, float> $weights */
        $weights = config("recommendations.priority_weights.{$priority->value}", config('recommendations.priority_weights.value'));

        $usage = $answers['usage'] ?? '';
        $boosts = config("recommendations.usage_boost.{$usage}", []);

        foreach ($boosts as $dimension => $boost) {
            $weights[$dimension] = ($weights[$dimension] ?? 0.0) + $boost;
        }

        $total = array_sum($weights);

        return collect($weights)
            ->map(fn (float $weight): float => $weight / $total)
            ->all();
    }

    /**
     * @param  Collection<int, array{car: Car, match_percentage: int, explanation: array<int, string>, warnings: array<int, array{label: string, message: string, penalty: int}>}>  $recommendations
     * @return array<int, array<string, mixed>>
     */
    private function serializeRecommendations(Collection $recommendations): array
    {
        return $recommendations
            ->values()
            ->map(function (array $recommendation, int $index): array {
                /** @var Car $car */
                $car = $recommendation['car'];
                $specifications = $car->specification?->specifications ?? [];

                return [
                    'rank' => $index + 1,
                    'match_percentage' => $recommendation['match_percentage'],
                    'make' => $car->make,
                    'model' => $car->model,
                    'variant' => $car->variant,
                    'body_type' => $car->body_type,
                    'price' => (float) $car->price,
                    'mileage' => (float) $car->mileage,
                    'safety_rating' => (float) $car->safety_rating,
                    'average_review_rating' => (float) $car->average_review_rating,
                    'specifications' => [
                        'airbags' => $specifications['airbags'] ?? null,
                        'adas' => $specifications['adas'] ?? false,
                        'boot_space_l' => $specifications['boot_space_l'] ?? null,
                        'engine_cc' => $specifications['engine_cc'] ?? null,
                        'power_bhp' => $specifications['power_bhp'] ?? null,
                        'sunroof' => $specifications['sunroof'] ?? false,
                        'fuel_type' => $specifications['fuel_type'] ?? null,
                        'transmission' => $specifications['transmission'] ?? null,
                    ],
                    'explanation' => $recommendation['explanation'],
                    'warnings' => collect($recommendation['warnings'])
                        ->map(fn (array $warning): array => [
                            'label' => $warning['label'],
                            'message' => $warning['message'],
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->all();
    }

    private function displayValue(mixed $value): string
    {
        if (! is_string($value) || $value === '') {
            return __('recommendations.warnings.not_specified');
        }

        return str_replace('-', ' ', $value);
    }
}
