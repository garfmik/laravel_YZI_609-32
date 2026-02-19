<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('restaurant_cuisine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('cuisine_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['restaurant_id', 'cuisine_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_cuisine');
    }
};
