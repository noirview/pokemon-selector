<?php

namespace App\Services\Pokemon;

use App\DTOs\PokemonDTO;
use Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Service
{
    private array $cacheResponse = [];

    public function getPokemons(): Generator
    {
        $pokemonChunkList = $this->getListPokemons();

        foreach ($pokemonChunkList as $pokemonList) {
            $pokemons = [];
            foreach ($pokemonList as $pokemon) {

                $url = Arr::get($pokemon, 'url');
                dump($url);

                $pokemon = $this->getPokemon($url);

                $name = Arr::get($pokemon, 'name');
                $baseExperience = Arr::get($pokemon, 'base_experience');
                $imgUrl = Arr::get($pokemon, 'sprites.front_default');

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
                        $natureName = Arr::get($nature, 'name');
                        if (!in_array($natureName, $natures)) {
                            $natures[] = $natureName;
                        }
                    }
                }

                $color = Arr::get($species, 'color.name');
                $genderRate = Arr::get($species, 'gender_rate');
                $growthRate = Arr::get($species, 'growth_rate.name');

                $pokemons[] = new PokemonDTO(
                    $imgUrl,
                    $name,
                    $genderRate,
                    $growthRate,
                    $natures,
                    $color,
                    $baseExperience,
                );
            }

            yield $pokemons;
        }
    }

    private function getListPokemons(): Generator
    {
        $results = [];
        $next = 'https://pokeapi.co/api/v2/pokemon?limit=100';

        while (true) {
            dump($next);
            $request = Http::get($next);

            $next = $request->json('next');

            yield array_merge($results, $request->json('results'));

            if (is_null($next)) {
                break;
            }
        }
    }

    private function getPokemon(string $url): array
    {
        $request = Http::get($url);

        $json = $request->json();

        return $json;
    }

    public function getSpecies(string $url): array
    {
        if (Arr::has($this->cacheResponse, $url)) {
            return $this->cacheResponse[$url];
        }

        $request = Http::get($url);

        $json = $request->json();
        $this->cacheResponse[$url] = $json;

        return $json;
    }

    public function getStat(string $url): array
    {
        if (Arr::has($this->cacheResponse, $url)) {
            return $this->cacheResponse[$url];
        }

        $request = Http::get($url);

        $json = $request->json();
        $this->cacheResponse[$url] = $json;

        return $json;
    }
}
