<?php

namespace App\Console\Commands\Pokemon;

use App\DTOs\PokemonDTO;
use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use App\Models\Pokemon;
use App\Services\Pokemon\Service as PokemonService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class Parse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        PokemonService $service
    )
    {
        $pokemons = $service->getPokemons();

        /** @var PokemonDTO $pokemon */
        foreach ($pokemons as $pokemonsChunk) {
            foreach ($pokemonsChunk as $pokemon) {
                $pokemonModel = new Pokemon([
                    'name' => $pokemon->name,
                    'growth_rate' => $this->transformGrowthRate($pokemon->growthRate),
                    'color' => $this->transformColor($pokemon->color),
                    'base_experience' => $pokemon->baseExperience,
                ]);

                $genders = $this->transformGenderRate($pokemon->genderRate);
                $genderModels = Arr::map($genders,
                    fn(Gender $gender) => ['gender' => $gender]
                );

                $natures = Arr::map($pokemon->natures, fn(string $nature) => $this->transformNature($nature));
                $natures = array_filter($natures);

                $natureModels = Arr::map($natures, fn(Nature $nature) => [
                    'nature' => $nature
                ]);

                $pokemonModel->save();
                if ($pokemon->imgUrl) {
                    $pokemonModel->addMediaFromUrl($pokemon->imgUrl)
                        ->toMediaCollection('sprite');
                }

                $pokemonModel->genders()->createMany($genderModels);
                $pokemonModel->natures()->createMany($natureModels);
            }
        }
    }

    private function transformGrowthRate(string $growthRate): GrowthRate
    {
        return match ($growthRate) {
            'slow' => GrowthRate::SLOW,
            'medium',
            'medium-slow',
            'slow-then-very-fast',
            'fast-then-very-slow' => GrowthRate::MEDIUM,
            'fast' => GrowthRate::FAST,
            default => throw new \Exception($growthRate),
        };
    }

    private function transformColor(string $color): Color
    {
        return match ($color) {
            'black' => Color::BLACK,
            'blue' => Color::BLUE,
            'brown' => Color::BROWN,
            'gray' => Color::GRAY,
            'green' => Color::GREEN,
            'pink' => Color::PINK,
            'purple' => Color::PURPLE,
            'red' => Color::RED,
            'white' => Color::WHITE,
            'yellow' => Color::YELLOW,
            default => throw new \Exception($color),
        };
    }

    private function transformGenderRate(int $genderRate): array
    {
        return match ($genderRate) {
            0 => [Gender::MALE],
            1,
            2,
            3,
            4,
            5,
            6,
            7 => [Gender::MALE, Gender::FEMALE],
            8 => [Gender::FEMALE],
            -1 => [Gender::GENDERLESS],
            default => throw new \Exception($genderRate),
        };
    }

    private function transformNature(string $nature): Nature|null
    {
        return match ($nature) {
            'hardy' => Nature::HARDY,
            'calm' => Nature::CALM,
            'docile' => Nature::DOCILE,
            'rash' => Nature::RASH,
            'quirky' => Nature::QUIRKY,
            default => null,
        };
    }
}
