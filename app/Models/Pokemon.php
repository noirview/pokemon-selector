<?php

namespace App\Models;

use App\Enums\Pokemon\Color;
use App\Enums\Pokemon\Gender;
use App\Enums\Pokemon\GrowthRate;
use App\Enums\Pokemon\Nature;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasUuids,
        HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'gender',
        'growth_rate',
        'nature',
        'color',
        'base_experience',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'growth_rate' => GrowthRate::class,
        'nature' => Nature::class,
        'color' => Color::class,
    ];
}
