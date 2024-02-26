<?php

namespace App\Models;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeGender(Builder $query, Gender|int $gender): Builder
    {
        return $query->whereHas('genders',
            fn(Builder $query) => $query->where('gender', $gender)
        );
    }

    public function scopeGrowthRate(Builder $query, GrowthRate|int $growthRate): Builder
    {
        return $query->where('growth_rate', $growthRate);
    }

    public function scopeNature(Builder $query, Nature|int $nature): Builder
    {
        return $query->whereHas('natures',
            fn(Builder $query) => $query->where('nature', $nature)
        );
    }

    public function scopeColor(Builder $query, Color|int $color): Builder
    {
        return $query->where('color', $color);
    }

    public function scopeOrderByBaseExperience(Builder $query, $direction = 'asc'): Builder
    {
        return $query->orderBy('base_experience', $direction);
    }
}
