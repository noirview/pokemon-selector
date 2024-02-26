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
        Schema::create('pokemon_genders', function (Blueprint $table) {
            $table->uuid()->unique();

            $table->string('pokemon_id');
            $table->foreign('pokemon_id')->references('id')->on('pokemons')
                ->cascadeOnDelete();

            $table->integer('gender');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_genders');
    }
};
