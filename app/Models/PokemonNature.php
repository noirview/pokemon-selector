<?php

namespace App\Models;

use App\Enums\Pokemon\Nature;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonNature extends Model
{
    use HasUuids;

    protected $fillable = [
        'pokemon_id',
        'nature',
    ];

    protected $casts = [
        'nature' => Nature::class,
    ];

    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }
}
