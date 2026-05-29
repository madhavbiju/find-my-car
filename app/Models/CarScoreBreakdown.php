<?php

namespace App\Models;

use Database\Factories\CarScoreBreakdownFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['car_id', 'score_type', 'reason', 'points'])]
class CarScoreBreakdown extends Model
{
    /** @use HasFactory<CarScoreBreakdownFactory> */
    use HasFactory;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
