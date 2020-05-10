<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){


        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['error'=>'The provided credentials are incorrect']);
        }

        return response()->json($user->createToken($request->device_name));
    }

    public function logout(){
        //TODO: FIX LOGOUT
        Auth::guard('web')->logout();

        Auth::user()->tokens()->delete();   // DELETES ALL TOKENS, it's good for now but should change!!!

        return response()->json(Auth::user()->tokens);
    }
}
