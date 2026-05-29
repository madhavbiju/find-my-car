<?php

namespace App\Jobs;

use App\Models\Car;
use App\Services\CarScoringService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateCarScoresJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Car $car) {}

    public function handle(CarScoringService $carScoringService): void
    {
        $carScoringService->calculateScores($this->car);
    }
}
