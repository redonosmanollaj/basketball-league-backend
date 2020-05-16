<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Http\Request;

class FansController extends Controller
{
    public function league(){
        $league = [];
        $teams = Team::all();
        foreach ($teams as $team){
            $temp = [
                'team' => $team->name,
                'matches' => $team->numberOfMatches,
                'wins' => $team->numberOfWins,
                'loses' => $team->numberOfLoses,
                'scored_points' => $team->scoredPoints,
                'accepted_points' => $team->acceptedPoints,
                'difference' => $team->difference,
                'league_points' => $team->leaguePoints
            ];
            $league[] = $temp;
        }

        usort($league,$this->leagueSorter('league_points','difference'));
        return response()->json($league);
    }

    public function results(){
        $weeks = Week::all();
        $result = [];
        foreach ($weeks as $week){
            $weekResults = [
                'week' => $week->number,
                'period' => $week->period
            ];

            $matches = $week->matches;
            foreach ($matches as $match){
                $teams = $match->teams;
                $temp = [
                    'home' => $match->homeTeam->name,
                    'away' => $match->awayTeam->name,
                    'home_score' => $match->home_score,
                    'away_score' => $match->away_score
                ];
                $weekResults['matches'][] = $temp;
            }
            $result[] = $weekResults;
        }

        return response()->json($result);
    }


    // HELPERS
    function leagueSorter($key1, $key2){
        return function ($a, $b) use ($key1,$key2){
            if($b[$key1] == $a[$key1])
                return $this->compare($b[$key2],$a[$key2]);
            return $this->compare($b[$key1],$a[$key1]);
        };
    }

    function compare($a,$b){
        if($a == $b) return 0;
        return $a<$b ? -1 : 1;
    }
}
