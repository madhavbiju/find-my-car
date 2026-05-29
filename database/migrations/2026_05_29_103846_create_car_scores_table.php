<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->smallInteger('family_score');
            $table->smallInteger('city_score');
            $table->smallInteger('highway_score');
            $table->smallInteger('safety_score');
            $table->smallInteger('performance_score');
            $table->smallInteger('comfort_score');
            $table->smallInteger('fuel_economy_score');
            $table->smallInteger('value_score');
            $table->timestamps();

            $table->unique('car_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_scores');
    }
};
