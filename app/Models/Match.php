<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{

    protected $fillable = ['home_score','away_score','date','created_at','updated_at'];

    public function week(){
        return $this->belongsTo('App\Models\Week');
    }

    public function teams(){
        return $this->belongsToMany('App\Models\Team')->withPivot('position');
    }

    public function getWinnerAttribute(){
        if($this->home_score > $this->away_score)
            return 'home';

        return 'away';
    }

    public function getHomeTeamAttribute(){
        $teams = $this->teams;
        if($teams[0]->pivot->position == 'home')
            return $teams[0];
        return $teams[1];
    }

    public function getAwayTeamAttribute(){
        $teams = $this->teams;
        if($teams[0]->pivot->position == 'home')
            return $teams[1];
        return $teams[0];
    }
}
