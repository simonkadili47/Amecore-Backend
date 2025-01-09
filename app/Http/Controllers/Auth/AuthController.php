<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the user input
            $validateUser = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                ],
            ], [
                'password.regex' => 'Password must be at least 8 characters, include at least one letter (either uppercase or lowercase), one number, and one special character.'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            // Create a new user
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User registered successfully!',
                'user_id' => $user->id
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during registration. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate the login credentials
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email or password is incorrect.'
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully!',
                'token' => $token,
                'full_name' => $user->full_name, 
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during login. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        $userData = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Profile information',
            'data' => [
                'id' => $userData->id,
                'full_name' => $userData->full_name,
                'email' => $userData->email,
                'phone_number' => $userData->phone_number
            ],
        ], 200);
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during logout.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
