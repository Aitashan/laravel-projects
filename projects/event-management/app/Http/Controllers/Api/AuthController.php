<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) 
        {
            throw ValidationException::withMessages([
                'email'=> ['The provided email is not correct']
        // 'email'=> ['The provided credentials are not correct']  this can be used in both cases to keep the wrong request private
            ]);
        }

        if (!Hash::check($request->password, $user->password))
        {
            throw ValidationException::withMessages([
                'password'=> ['The provided password is not correct']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token'=> $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message'=> 'user logged out sucessfully'
        ]);
    }
}
