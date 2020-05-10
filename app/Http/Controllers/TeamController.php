<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function all(){
        $teams = Team::all();
        return response()->json($teams);
    }

    public function store(Request $request){
        try{
            $team = new Team($request->all());
            $team->save();
        }catch (\Exception $exception){
            $message = $exception->getMessage();
            if($exception->getCode() == 23000)
                $message = "This team name exists in database";
            return response()->json(['error'=>$message]);
        }

        return response()->json($team);

    }

    public function update($id, Request $request){
        try{
            $team = Team::findOrFail($id);
            $team->update($request->all());
        } catch (\Exception $exception){
            $message = $exception->getMessage();
            if($exception->getCode() == 23000)
                $message = "This team name exists in database";
            return response()->json(['error' => $message]);
        }
        return response()->json($team);
    }

    public function destroy($id){
        try{
            $team = Team::findOrFail($id);
            $team->delete();
        } catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
        return response()->json($team);

    }
}
