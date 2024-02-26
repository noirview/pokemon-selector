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
        Schema::create('pokemon_natures', function (Blueprint $table) {
            $table->uuid('id')->unique();

            $table->string('pokemon_id');
            $table->foreign('pokemon_id')->references('id')->on('pokemons')
                ->cascadeOnDelete();

            $table->integer('nature');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_natures');
    }
};
