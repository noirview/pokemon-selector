<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pokemons\IndexRequest;
use App\Repositories\Pokemons\PokemonRepository;

class PokemonController extends Controller
{
    public function __construct(
        private PokemonRepository $repository,
    ) {}

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
        $pokemons = $this->repository->filterBy(
            $request->integer('gender'),
            $request->integer('growth_rate'),
            $request->integer('nature'),
            $request->integer('color'),
        );

        $weakPokemons = $this->repository->weakFilterBy(
            $request->integer('gender'),
            $request->integer('growth_rate'),
            $request->integer('nature'),
            $request->integer('color'),
        );

        return redirect()->back()
            ->withInput()
            ->with('pokemons', $pokemons)
            ->with('weak_pokemons', $weakPokemons);
    }
}
