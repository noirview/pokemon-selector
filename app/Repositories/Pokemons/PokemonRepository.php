<?php

namespace App\Repositories\Pokemons;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use Illuminate\Support\Collection;

class PokemonRepository
{
    public function getAllBy(
        Gender     $gender,
        GrowthRate $growthRate,
        Nature     $nature,
        Color      $color,
    ): Collection
    {
        return collect();
    }
}
