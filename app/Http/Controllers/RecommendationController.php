<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecommendationRequest;
use App\Models\RecommendationSession;
use App\Services\RecommendationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RecommendationController extends Controller
{
    public function __construct(private RecommendationService $recommendations) {}

    public function create(): Response
    {
        $previousAnswers = null;

        if ($fromId = request()->query('from')) {
            $session = RecommendationSession::find($fromId);
            $previousAnswers = $session?->answers;
        }

        return Inertia::render('RecommendationFormPage', [
            'previousAnswers' => $previousAnswers,
        ]);
    }

    public function store(StoreRecommendationRequest $request): RedirectResponse
    {
        $result = $this->recommendations->generateRecommendations($request->validated());

        return to_route('recommendations.show', $result['session']);
    }

    public function show(RecommendationSession $session): Response
    {
        return Inertia::render('RecommendationResultsPage', [
            'session' => $session,
            'recommendations' => $this->recommendations->getRecommendationsForSession($session),
        ]);
    }
}
