<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        // validation
        $fields = $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:4'
        ]);
        $fields['password']= Hash::make($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user'=>$user,
            'token'=>$token
        ],201);
    }
    public function login(Request $request){
        // validation
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:4'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return [
                'message'=>'the provided credentails are incorrect.'
            ];
        }
        $token = $user->createToken($user->name);
        return response()->json([
            'user'=>$user,
            'token'=>$token->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        
            return response()->json([
                'message' => 'Logout Successfully'
            ]);
        }
    
        return response()->json([
            'message' => 'User not authenticated'
        ], 401);
    }

    
}

