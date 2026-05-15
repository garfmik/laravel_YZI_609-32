<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('website')->nullable()->change();
            $table->decimal('average_price', 10, 2)->nullable()->change();
            $table->string('opening_hours')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            //
        });
    }
};
