<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'userName' => $user->name,
            'role' => $user->getRoleNames()[0]
        ], 200);
    }

    public function register(Request $request){
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string',
                'role' => 'required|string|exists:roles,name',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $user->assignRole($request->role);
        } catch (\Exception $error) {
            return response()->json(['message' => $error], 500);
        }
    }
}
