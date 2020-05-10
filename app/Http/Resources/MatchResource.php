<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'home' => $this->homeTeam->name,
            'away' => $this->awayTeam->name,
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'week' => $this->week->number
        ];
    }
}
