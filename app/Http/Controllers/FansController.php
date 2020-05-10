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
        // TODO: ANOTHER SORTING ALGORITHM
        usort($league,$this->build_sorter('league_points'));
        return response()->json($league);
    }

    function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($b[$key],$a[$key]);
        };
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
}
