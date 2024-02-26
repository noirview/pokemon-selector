<?php

namespace App\Services\Pokemon;

use App\DTOs\PokemonDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Service
{
    public function getPokemons(): array
    {
        $pokemons = [];
        $pokemonsList = $this->getListPokemons();

        foreach ($pokemonsList as $pokemon) {
            $url = Arr::get($pokemon, 'url');
            $pokemon = $this->getPokemon($url);

            $name = Arr::get($pokemon, 'name');
            $baseExperience = Arr::get($pokemon, 'base_experience');

            $species = Arr::get($pokemon, 'species');
            $url = Arr::get($species, 'url');
            $species = $this->getSpecies($url);

            $stats = Arr::get($pokemon, 'stats');

            $urls = Arr::map($stats, fn(array $stat) => Arr::get($stat, 'stat.url'));
            $natures = [];
            foreach ($urls as $url) {
                $stat = $this->getStat($url);
                $affectingNatures = Arr::get($stat, 'affecting_natures');

                $increase = Arr::get($affectingNatures, 'increase');
                $decrease = Arr::get($affectingNatures, 'decrease');

                foreach (array_merge($increase, $decrease) as $nature) {
                    $name = Arr::get($nature, 'name');
                    if (!in_array($name, $natures)) {
                        $natures[] = $name;
                    }
                }
            }

            $color = Arr::get($species, 'color.name');
            $genderRate = Arr::get($species, 'gender_rate');
            $growthRate = Arr::get($species, 'growth_rate.name');

            $pokemons[] = new PokemonDTO(
                $name,
                $genderRate,
                $growthRate,
                $natures,
                $color,
                $baseExperience,
            );
        }

        return $pokemons;
    }

    private function getListPokemons(): array
    {
        $results = [];
        $next = 'https://pokeapi.co/api/v2/pokemon?limit=100';

        while (true) {
            $request = Http::get($next);

            $next = $request->json('next');
            $results = array_merge($results, $request->json('results'));

            dump($next);
            if (is_null($next)) {
                break;
            }
        }

        return $results;
    }

    private function getPokemon(string $url): array
    {
        $request = Http::get($url);

        $json = $request->json();

        return $json;
    }

    public function getSpecies(string $url): array
    {
        $request = Http::get($url);

        $json = $request->json();

        return $json;
    }

    public function getStat(string $url): array
    {
        $request = Http::get($url);

        $json = $request->json();

        return $json;
    }
}
