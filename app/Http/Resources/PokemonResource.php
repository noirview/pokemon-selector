<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'gender' => $this->gender,
            'growth_rate' => $this->growth_rate,
            'nature' => $this->nature,
            'color' => $this->color,
            'base_experience' => $this->base_experience,
        ];
    }
}
