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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('variant', 200);
            $table->string('body_type', 50);
            $table->decimal('price', 12, 2);
            $table->decimal('mileage', 6, 2);
            $table->decimal('safety_rating', 3, 1);
            $table->decimal('average_review_rating', 3, 2)->default(0);
            $table->timestamps();

            $table->unique(['make', 'model', 'variant']);
            $table->index('price');
            $table->index('body_type');
            $table->index('safety_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
