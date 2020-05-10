<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatchResource;
use App\Http\Resources\WeekResource;
use App\Models\Week;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function all(){
        $weeks = Week::all();

        return WeekResource::collection($weeks);
    }

    public function show($id){
        $week = Week::findOrFail($id);
        return new WeekResource($week);
    }

    public function store(Request $request){
        try{
            $week = new Week($request->all());
            $week->save();
        } catch (\Exception $exception){
            $message = $exception->getMessage();
            if($exception->getCode() == 23000)
                $message = 'This week exists in database';
            return response()->json(['error' => $message]);
        }

        return new WeekResource($week);

    }

    public function update($id, Request $request){
        try{
            $week = Week::findOrFail($id);
            $week->update($request->only(['number','period']));
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }

        return new WeekResource($week);
    }

    public function destroy($id){
        try{
            $week = Week::findOrFail($id);

            if(sizeof($week->matches) > 0)
                return response()->json(['error' => 'You cannot delete a week that has matches. To do it you should delete matches of that week.']);
            else
                $week->delete();
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        return new WeekResource($week);
    }
}
