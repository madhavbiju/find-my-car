<?php

namespace App\Models;

use App\Jobs\CalculateCarScoresJob;
use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['make', 'model', 'variant', 'body_type', 'price', 'mileage', 'safety_rating', 'average_review_rating'])]
class Car extends Model
{
    /** @use HasFactory<CarFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::created(function (Car $car): void {
            CalculateCarScoresJob::dispatch($car);
        });
    }

    public function specification(): HasOne
    {
        return $this->hasOne(CarSpecification::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function score(): HasOne
    {
        return $this->hasOne(CarScore::class);
    }

    public function scoreBreakdowns(): HasMany
    {
        return $this->hasMany(CarScoreBreakdown::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'mileage' => 'decimal:2',
            'safety_rating' => 'decimal:1',
            'average_review_rating' => 'decimal:2',
        ];
    }
}
