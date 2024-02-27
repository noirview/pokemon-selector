<?php

namespace App\DTOs;

class PokemonDTO
{
    public function __construct(
        public readonly string   $imgUrl,
        public readonly string   $name,
        public readonly int      $genderRate,
        public readonly int      $growthRate,
        public readonly array    $natures,
        public readonly string   $color,
        public readonly int|null $baseExperience,
    ) {}
}
