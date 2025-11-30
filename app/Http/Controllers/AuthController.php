<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\EmailVerification as ModelsEmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Pest\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        // validation
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:4'
        ]);
        $token = Str::random(64);

        $tempUser = ModelsEmailVerification::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'token' => $token,
        ]);

        Mail::to($tempUser->email)->send(new EmailVerification($token,$tempUser));
        
            return response()->json([
                'message'=>'check your email....'
            ]);     
    }

    public function verifyMail($token)
    {
        $tempUser = ModelsEmailVerification::where('token', $token)->first();

                
        if(!$tempUser){
            return response()->json(['message' => 'Invalid or expired token'], 400);
        }
        User::create([
            'name'=>$tempUser->name,
            'email'=>$tempUser->email,
            'password'=>Hash::make($tempUser->password)
        ]);
    
        
        $tempUser->delete();
    
        return "Email verified successfully!";
    }




    // under creating........
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
        // dd($user);
        $token = $user->createToken('auth_token');
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

