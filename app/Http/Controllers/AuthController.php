<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);

        // Attempt to log the user in
        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Login information is invalid!'], 401);
        }

        // Retrieve the authenticated user
        $user = User::where('email', $validated['email'])->first(); // Use first() to get the user instance

        // Generate an access token for the user
        $accessToken = $user->createToken('api_token')->plainTextToken;

        // Return a success response
        return response()->json([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'user' => [
                "id" => $user->id,
                "name" => $user->first_name
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Delete all tokens for the authenticated user
        $request->user()->tokens()->delete();
        // $user():currently authenticated user from the request.
        return response()->json(['message' => 'The user logged out']);
    }
}
