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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->json('food_type_ids'); // Store multiple food_type IDs
            $table->string('name');
            $table->string('name_ar');
            $table->text('logo');
            $table->text('thumbnail');
            $table->string('description');
            $table->string('description_ar');
            $table->string('slug');
            $table->string('slug_ar');
            $table->unsignedBigInteger('Rank');
            $table->unsignedBigInteger('recommendation');
            $table->string('cost');
            $table->string('restaurant_code');
            $table->text('images');
            $table->string('hotline');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
