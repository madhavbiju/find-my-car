<?php

use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'LandingPage')->name('home');

Route::get('/recommendations/create', [RecommendationController::class, 'create'])->name('recommendations.create');
Route::post('/recommendations', [RecommendationController::class, 'store'])->name('recommendations.store');
Route::get('/recommendations/{session}', [RecommendationController::class, 'show'])->name('recommendations.show');
