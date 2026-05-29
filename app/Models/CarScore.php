<?php

namespace App\Models;

use Database\Factories\CarScoreFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['car_id', 'family_score', 'city_score', 'highway_score', 'safety_score', 'performance_score', 'comfort_score', 'fuel_economy_score', 'value_score'])]
class CarScore extends Model
{
    /** @use HasFactory<CarScoreFactory> */
    use HasFactory;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
