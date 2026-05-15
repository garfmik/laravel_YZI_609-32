<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->tinyInteger('food_rating')->nullable()->change();
            $table->tinyInteger('service_rating')->nullable()->change();
            $table->tinyInteger('atmosphere_rating')->nullable()->change();
            $table->tinyInteger('price_quality_rating')->nullable()->change();
            $table->tinyInteger('interior_rating')->nullable()->change();
            $table->tinyInteger('location_rating')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->tinyInteger('food_rating')->nullable(false)->change();
            $table->tinyInteger('service_rating')->nullable(false)->change();
            $table->tinyInteger('atmosphere_rating')->nullable(false)->change();
            $table->tinyInteger('price_quality_rating')->nullable(false)->change();
            $table->tinyInteger('interior_rating')->nullable(false)->change();
            $table->tinyInteger('location_rating')->nullable(false)->change();
        });
    }
};
