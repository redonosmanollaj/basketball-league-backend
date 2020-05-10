<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = ['name','coach','telephone','email','logo'];
    public $timestamps = false;

    public function matches(){
        return $this->belongsToMany('App\Models\Match')->withPivot('position');
    }

    public function getNumberOfMatchesAttribute(){
        return $this->matches()->count();
    }

    public function getNumberOfWinsAttribute(){
        $numberOfWins = 0;
        foreach ($this->matches as $match){
            if($match->pivot->position == $match->winner)
                $numberOfWins++;
        }
        return $numberOfWins;
    }

    public function getNumberOfLosesAttribute(){
        $numberOfLoses = 0;
        foreach ($this->matches as $match){
            if($match->pivot->position !== $match->winner)
                $numberOfLoses++;
        }
        return $numberOfLoses;
    }

    public function getScoredPointsAttribute(){
        $scoredPoints = 0;
        foreach ($this->matches as $match){
            if($match->pivot->position == 'home')
                $scoredPoints = $scoredPoints + $match->home_score;
            else
                $scoredPoints = $scoredPoints + $match->away_score;
        }
        return $scoredPoints;
    }

    public function getAcceptedPointsAttribute(){
        $acceptedPoints = 0;
        foreach ($this->matches as $match){
            if($match->pivot->position !== 'home')
                $acceptedPoints = $acceptedPoints + $match->home_score;
            else
                $acceptedPoints = $acceptedPoints + $match->away_score;
        }
        return $acceptedPoints;
    }

    public function getDifferenceAttribute(){
        return $this->scoredPoints - $this->acceptedPoints;
    }

    public function getLeaguePointsAttribute(){
        return $this->numberOfWins*2 + $this->numberOfLoses;
    }
}
