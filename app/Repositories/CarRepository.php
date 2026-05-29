<?php

namespace App\Repositories;

use App\Enums\BudgetRange;
use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarRepository
{
    /**
     * @param  array<string, string>  $criteria
     * @return Collection<int, Car>
     */
    public function getRecommendationCandidates(array $criteria): Collection
    {
        $query = Car::query()
            ->with(['score', 'scoreBreakdowns', 'specification'])
            ->whereHas('score')
            ->whereHas('specification');

        if ($budget = BudgetRange::tryFrom($criteria['budget'] ?? '')) {
            [$minimum, $maximum] = $budget->priceBounds();

            if ($minimum !== null) {
                $query->where('price', '>=', $minimum * config('recommendations.budget_lower_grace'));
            }

            if ($maximum !== null) {
                $query->where('price', '<=', $maximum * config('recommendations.budget_upper_grace'));
            }
        }

        return $query->orderByDesc('average_review_rating')->get();
    }

    /**
     * @param  array<string, string>  $criteria
     * @return Collection<int, Car>
     */
    public function getTopMatches(array $criteria): Collection
    {
        return $this->getRecommendationCandidates($criteria)->take(3);
    }

    public function findById(int $id): ?Car
    {
        return Car::query()
            ->with(['score', 'scoreBreakdowns', 'specification'])
            ->find($id);
    }

    /**
     * @param  array<int, int>  $ids
     * @return Collection<int, Car>
     */
    public function findManyByIds(array $ids): Collection
    {
        return Car::query()
            ->with(['score', 'scoreBreakdowns', 'specification'])
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(fn (Car $car) => array_search($car->id, $ids, true))
            ->values();
    }
}
