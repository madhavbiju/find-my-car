<?php

namespace App\Http\Middleware;

use App\Enums\BodyType;
use App\Enums\BudgetRange;
use App\Enums\FamilySize;
use App\Enums\FuelType;
use App\Enums\MonthlyKilometers;
use App\Enums\Transmission;
use App\Enums\UsageType;
use App\Enums\UserPriority;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'lang' => [
                'recommendations' => array_merge(
                    trans('recommendations'),
                    [
                        'options' => [
                            'budget' => BudgetRange::toOptions(),
                            'usage' => UsageType::toOptions(),
                            'family_size' => FamilySize::toOptions(),
                            'monthly_km' => MonthlyKilometers::toOptions(),
                            'fuel_type' => FuelType::toOptions(),
                            'body_type' => BodyType::toOptions(),
                            'transmission' => Transmission::toOptions(),
                            'priority' => UserPriority::toOptions(),
                        ],
                    ]
                ),
            ],
        ];
    }
}
