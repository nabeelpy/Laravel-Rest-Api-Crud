<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected function register(Request $request)
    {

        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);


        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' =>$user,
            'token' =>$token
        ];


        return response($response, 201);

    }

    protected function login(Request $request)
    {

        $fields = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);


        $user = User::where('email' , $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => "Wrong Credentials"
            ], 401);
        }


        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' =>$user,
            'token' =>$token
        ];


        return response($response, 201);

    }


    public function logout(Request $request){
//        auth()->user()->tokens()->delete();

        $request->user()->currentAccessToken()->delete();

//        dd(Auth::check());
//        dd(Auth::user());

        return [
            'message' => 'Logged Out'
        ];
    }


}
