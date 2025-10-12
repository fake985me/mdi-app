<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $profiles = Profile::with('user')->get();
        
        // Format the response to match what the frontend expects
        return response()->json([
            'data' => $profiles->map(function ($profile) {
                return [
                    'id' => $profile->id,
                    'full_name' => $profile->full_name,
                    'email' => $profile->email,
                    'role' => $profile->role,
                    'created_at' => $profile->created_at,
                    'user_id' => $profile->user_id
                ];
            })
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,superadmin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create profile for the user
        $profile = Profile::create([
            'user_id' => $user->id,
            'full_name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? 'user'
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $profile
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $profile = Profile::with('user')->findOrFail($id);
        
        return response()->json([
            'data' => [
                'id' => $profile->id,
                'full_name' => $profile->full_name,
                'email' => $profile->email,
                'role' => $profile->role,
                'created_at' => $profile->created_at,
                'user_id' => $profile->user_id
            ]
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'sometimes|string|max:255',
            'role' => 'sometimes|in:user,admin,superadmin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile->update($request->only(['full_name', 'role']));

        // Update the associated user name as well
        if ($request->has('full_name')) {
            $profile->user->update(['name' => $request->full_name]);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $profile
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        
        // Delete the associated user which will cascade delete the profile
        $profile->user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}