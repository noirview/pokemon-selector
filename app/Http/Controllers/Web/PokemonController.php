<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pokemons\IndexRequest;
use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Builder;

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
            ->gender($request->integer('gender'))
            ->growthRate($request->integer('growth_rate'))
            ->nature($request->integer('nature'))
            ->color($request->integer('color'))
            ->orderByBaseExperience('desc')
            ->get();

        return redirect()->back()
            ->withInput()
            ->with('pokemons', $pokemons);
    }
}
