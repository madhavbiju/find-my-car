<?php

namespace App\Repositories;

use App\Models\RecommendationSession;

class RecommendationSessionRepository
{
    /**
     * @param  array{answers: array<string, string>, recommended_car_ids?: array<int, int>}  $data
     */
    public function create(array $data): RecommendationSession
    {
        return RecommendationSession::query()->create($data);
    }

    /**
     * @param  array<int, int>  $carIds
     */
    public function updateRecommendations(int $sessionId, array $carIds): RecommendationSession
    {
        $session = RecommendationSession::query()->findOrFail($sessionId);

        $session->update([
            'recommended_car_ids' => $carIds,
        ]);

        return $session;
    }
}
