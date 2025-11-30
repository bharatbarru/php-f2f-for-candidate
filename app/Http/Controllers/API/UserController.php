<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{
     public function signup(Request $request)
{
    // Validate input
    $validator = Validator::make($request->all(), [
        "name" => "required",
        "email" => "required|email",
        "password" => "required|min:6"
    ]);

    if ($validator->fails()) {
        return response()->json([
            "message" => "Validation error",
            "errors" => $validator->errors()
        ], 422);
    }

    // Check if user already exists
    $existingUser = User::where('email', $request->email)->first();

    if ($existingUser) {
        return response()->json([
            "message" => "User already exists with this email"
        ], 409);
    }

    // Create user
    $user = User::create([
        "name" => $request->name,
        "email" => $request->email,
        "password" => Hash::make($request->password)
    ]);

    return response()->json([
        "message" => "User registered successfully",
        "user" => $user
    ], 201);
}


    public function login(Request $request)
{
    LOG::info($request->all());
    LOG::info(env("API_KEY"));
    // Step 1: Validate API Key
    if ($request->apikey !== env("API_KEY")) {
        return response()->json(["message" => "Invalid API key"], 401);
    }

    // Step 2: Validate request input
    $validator = Validator::make($request->all(), [
        "email" => "required|email",
        "password" => "required"
    ]);

    if ($validator->fails()) {
        return response()->json([
            "message" => "Validation error",
            "errors" => $validator->errors()
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (! $user) {
        return response()->json([
            "message" => "User does not exist"
        ], 404);
    }

    if (! Hash::check($request->password, $user->password)) {
        return response()->json([
            "message" => "Invalid password"
        ], 401);
    }

    $token = JWTAuth::fromUser($user);

    return response()->json([
        "message" => "Login successful",
        "token" => $token,
        "user" => $user
    ]);
}

}
