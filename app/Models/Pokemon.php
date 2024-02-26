<?php

namespace App\Models;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\GrowthRate;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pokemon extends Model
{
    use HasUuids,
        HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'growth_rate',
        'color',
        'base_experience',
    ];

    protected $casts = [
        'growth_rate' => GrowthRate::class,
        'color' => Color::class,
    ];

    public function genders(): HasMany
    {
        return $this->hasMany(PokemonGender::class);
    }

    public function natures(): HasMany
    {
        return $this->hasMany(PokemonNature::class);
    }
}
