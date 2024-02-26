<?php

namespace App\Models;

use App\Enums\Pokemon\Gender;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonGender extends Model
{
    use HasUuids;

    protected $fillable = [
        'pokemon_id',
        'gender',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }
}
