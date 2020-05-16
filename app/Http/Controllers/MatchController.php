<?php

namespace App\Http\Controllers;

use App\Events\NewMatch;
use App\Http\Resources\MatchResource;
use App\Models\Match;
use App\Models\Team;
use App\Models\Week;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function all(){
        $matches = Match::all();
        return MatchResource::collection($matches);
    }

    public function show($id){
        $match = Match::findOrFail($id);

        return new MatchResource($match);
    }

    public function store(Request $request){
        try{
            $match = new Match($request->except(['week_id','home_id','away_id']));

            $week = Week::findOrFail($request->week_id);
            $week->matches()->save($match);

            $match->teams()->attach($request->home_id,['position'=>'home']);
            $match->teams()->attach($request->away_id,['position'=>'away']);

            broadcast(new NewMatch($match))->toOthers();
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        return new MatchResource($match);
    }

    public function update($id, Request $request){
        try{
            $match = Match::findOrFail($id);
            $match->update($request->only(['home_score','away_score']));

            if($request->has('home_id')){
                $match->teams()->detach($match->homeTeam->id);
                $match->teams()->attach($request->home_id,['position'=>'home']);
            }

            if($request->has('away_id')){
                $match->teams()->detach($match->awayTeam->id);
                $match->teams()->attach($request->away_id,['position'=>'away']);
            }
            $match->save();
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        return new MatchResource($match);
    }

    public function destroy($id){
        try{
            $match = Match::findOrFail($id);
            $match->teams()->detach($match->homeTeam->id);
            $match->teams()->detach($match->awayTeam->id);
            $match->delete();
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        return new MatchResource($match);
    }
}
