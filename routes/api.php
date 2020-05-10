<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login','Auth\LoginController@login');


// Fans Endpoints
Route::get('league','FansController@league');
Route::get('results','FansController@results');

// Common
Route::get('teams','TeamController@all');
Route::get('weeks','WeekController@all');
Route::get('weeks/{id}','WeekController@show');
Route::get('matches','MatchController@all');
Route::get('matches/{id}','MatchController@show');


// Admin Endpoints
Route::middleware('auth:sanctum')->group(function() {

    Route::get('/user',function (){
        return response()->json(Auth::user());
    });

    Route::post('/logout','Auth\LoginController@logout');

    Route::post('teams','TeamController@store');
    Route::put('teams/{id}','TeamController@update');
    Route::delete('teams/{id}','TeamController@destroy');

    Route::post('weeks','WeekController@store');
    Route::put('weeks/{id}','WeekController@update');
    Route::delete('weeks/{id}','WeekController@destroy');

    Route::post('matches','MatchController@store');
    Route::put('matches/{id}','MatchController@update');
    Route::delete('matches/{id}','MatchController@destroy');
});



