<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pokemons\IndexRequest;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;

class PokemonController extends Controller
{
    public function index(IndexRequest $request)
    {
        $pokemons = Pokemon::query()
            ->select(['name', 'gender', 'growth_rate', 'nature', 'color', 'base_experience'])

            ->where('gender', $request->integer('gender'))
            ->where('growth_rate', $request->integer('growth_rate'))
            ->where('nature', $request->integer('nature'))
            ->where('color', $request->integer('color'))

            ->orderByDesc('base_experience')
            ->get();

        return PokemonResource::collection($pokemons);
    }
}
