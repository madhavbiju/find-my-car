<?php

namespace App\Models;

use Database\Factories\RecommendationSessionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['answers', 'recommended_car_ids'])]
class RecommendationSession extends Model
{
    /** @use HasFactory<RecommendationSessionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'recommended_car_ids' => 'array',
        ];
    }
}
