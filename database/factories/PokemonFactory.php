<?php

namespace Database\Factories;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pokemon>
 */
class PokemonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(Gender::class),
            'growth_rate' => $this->faker->randomElement(GrowthRate::class),
            'nature' => $this->faker->randomElement(Nature::class),
            'color' => $this->faker->randomElement(Color::class),
            'base_experience' => $this->faker->randomDigitNotNull,
        ];
    }
}
