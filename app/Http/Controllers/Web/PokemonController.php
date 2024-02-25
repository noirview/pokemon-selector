<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pokemons\IndexRequest;
use App\Models\Pokemon;

class PokemonController extends Controller
{
    public function index()
    {
        $genders = \App\Enums\Pokemon\Gender::cases();
        $growthRates = \App\Enums\Pokemon\GrowthRate::cases();
        $natures = \App\Enums\Pokemon\Nature::cases();
        $colors = \App\Enums\Pokemon\Color::cases();

        return view('test', [
            'genders' => $genders,
            'growth_rates' => $growthRates,
            'natures' => $natures,
            'colors' => $colors,
        ]);
    }

    public function filter(IndexRequest $request)
    {
        $pokemons = Pokemon::query()
            ->select(['name', 'gender', 'growth_rate', 'nature', 'color', 'base_experience'])
            ->where('gender', $request->integer('gender'))
            ->where('growth_rate', $request->integer('growth_rate'))
            ->where('nature', $request->integer('nature'))
            ->where('color', $request->integer('color'))
            ->orderByDesc('base_experience')
            ->get();

        return redirect()->back()
            ->withInput()
            ->with('pokemons', $pokemons);
    }
}
