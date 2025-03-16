<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     // User Registration
     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'email' => 'required|string|email|unique:users',
             'password' => 'required|string|min:6|confirmed',
         ]);
 
         if ($validator->fails()) {
             return response()->json($validator->errors(), 400);
         }
 
         $user = User::create([
             'first_name' => $request->first_name,
             'last_name' => $request->last_name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);
 
         $token = $user->createToken('AuthToken')->accessToken;         
 
         return response()->json(['message' => "Registration successfuly completed" , 'token' => $token], 201);
     }



     //login the userr
     public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;         

            return response()->json(['user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }



    //logout the user 
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }



}
