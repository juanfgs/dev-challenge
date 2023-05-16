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
        Schema::create('actor_series', function (Blueprint $table) {

            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('series_id');
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->foreign('series_id')->references('id')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_series');
    }
};
