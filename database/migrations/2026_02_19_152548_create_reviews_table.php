<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');

            $table->tinyInteger('food_rating');
            $table->tinyInteger('service_rating');
            $table->tinyInteger('atmosphere_rating');
            $table->tinyInteger('price_quality_rating');
            $table->tinyInteger('interior_rating');
            $table->tinyInteger('location_rating');
            $table->decimal('overall_rating', 3, 2)->default(0);

            $table->text('impressions')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->string('image_path')->nullable();

            $table->timestamps();

            $table->unique(['user_id','restaurant_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
