<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'The provided credentials are incorrect.',
                    'errors' => ['email' => ['The provided credentials are incorrect.']]
                ], 401);
            }

            // Check if user has a profile, create one if not
            $profile = Profile::where('user_id', (string)$user->id)->first();
            if (!$profile) {
                // If no profile with this user_id, try to find by email
                $profile = Profile::where('email', $user->email)->first();
                if ($profile) {
                    // Update existing profile with user_id to link it
                    $profile->user_id = (string)$user->id;
                    $profile->save();
                } else {
                    // Create new profile
                    $profile = Profile::create([
                        'user_id' => (string)$user->id,
                        'email' => $user->email,
                        'full_name' => $user->name,
                        'role' => 'user'
                    ]);
                }
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'profile' => $profile,
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred during login',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create profile for the user
            // Check if a profile already exists for this email
            $profile = Profile::where('email', $request->email)->first();
            if ($profile) {
                // Update existing profile with user_id to link it
                $profile->user_id = (string)$user->id;
                $profile->full_name = $request->name;
                $profile->save();
            } else {
                // Create new profile
                $profile = Profile::create([
                    'user_id' => (string)$user->id,
                    'full_name' => $request->name,
                    'email' => $request->email,
                    'role' => 'user'
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $request->email,
                ],
                'profile' => $profile,
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get authenticated user details
     */
    public function user(Request $request)
    {
        try {
            $profile = Profile::where('user_id', (string)$request->user()->id)->first();

            return response()->json([
                'user' => $request->user(),
                'profile' => $profile
            ]);
        } catch (\Exception $e) {
            \Log::error('User details fetch error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching user details',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}