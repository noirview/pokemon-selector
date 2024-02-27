<?php

namespace App\Repositories\Pokemons;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use App\Models\Pokemon;
use Illuminate\Support\Collection;

class PokemonRepository
{
    public function getAllBy(
        Gender|int     $gender,
        GrowthRate|int $growthRate,
        Nature|int     $nature,
        Color|int      $color,
    ): Collection
    {
        return Pokemon::query()
            ->with('media')
            ->gender($gender)
            ->growthRate($growthRate)
            ->nature($nature)
            ->color($color)
            ->orderByBaseExperience('desc')
            ->get();
    }
}
