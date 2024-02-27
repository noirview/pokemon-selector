<?php

namespace App\Repositories\Pokemons;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PokemonRepository
{
    public function filterBy(
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

    public function weakFilterBy(
        Gender|int     $gender,
        GrowthRate|int $growthRate,
        Nature|int     $nature,
        Color|int      $color,
    )
    {
        return Pokemon::query()
            ->with('media')
            ->whereDoesntHave('genders', fn(Builder $query) => $query->where('gender', $gender))
            ->growthRate($growthRate)
            ->nature($nature)
            ->color($color)
            ->union(Pokemon::query()
                ->with('media')
                ->gender($gender)
                ->whereNot('growth_rate', $growthRate)
                ->nature($nature)
                ->color($color))
            ->union(Pokemon::query()
                ->with('media')
                ->gender($gender)
                ->growthRate($growthRate)
                ->whereDoesntHave('natures', fn(Builder $query) => $query->where('nature', $gender))
                ->color($color))
            ->union(Pokemon::query()
                ->with('media')
                ->gender($gender)
                ->growthRate($growthRate)
                ->nature($nature)
                ->whereNot('color', $color)
            )
            ->orderByBaseExperience('desc')
            ->get();
    }
}
