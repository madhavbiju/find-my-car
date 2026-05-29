<?php

namespace App\Models;

use App\Jobs\CalculateCarScoresJob;
use Database\Factories\CarSpecificationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['car_id', 'specifications'])]
class CarSpecification extends Model
{
    /** @use HasFactory<CarSpecificationFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::updated(function (CarSpecification $carSpecification): void {
            CalculateCarScoresJob::dispatch($carSpecification->car);
        });
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specifications' => 'array',
        ];
    }
}
