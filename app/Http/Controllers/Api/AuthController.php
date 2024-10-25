<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\NewUserNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' =>'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'status' => false,
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('API Token of'.$user->name)->plainTextToken
            ],
        ], 200);
    }


    public function register(Request $request) {
        $request->validate( [
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Send email notification to admin
        $admin = User::where('is_admin', true)->firstOrFail();
        Mail::to($admin->email)->send(new NewUserNotification($user));

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('API Token of'.$user->name)->plainTextToken
            ],
        ], 200);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
           'message' => 'Logged out successfully',
        ], 200);
    }

}
