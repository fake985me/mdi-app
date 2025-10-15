<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        // Check if the authenticated user has permission to view users
        $user = $request->user();
        if ($user->role !== 'superadmin' && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized access to user management'
            ], 403);
        }

        // Only return users if the requesting user is a superadmin or admin
        $users = User::when($user->role !== 'superadmin', function ($query) {
            return $query->where('role', '!=', 'superadmin');
        })
        ->select(['id', 'name', 'email', 'role', 'created_at'])
        ->get();
        
        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Check if the authenticated user has permission to create users
        $user = $request->user();
        if ($user->role !== 'superadmin') {
            return response()->json([
                'message' => 'Only superadmins can create users'
            ], 403);
        }

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
            'role' => $request->role
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $targetUser = User::findOrFail($id);
        
        // Check if the authenticated user has permission to view this user
        if ($user->role !== 'superadmin' && ($user->role !== 'admin' || $targetUser->role === 'superadmin')) {
            return response()->json([
                'message' => 'Unauthorized access to user details'
            ], 403);
        }
        
        return response()->json([
            'data' => $targetUser
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $authUser = $request->user();
        $targetUser = User::findOrFail($id);
        
        // Check if the authenticated user has permission to update this user
        if ($authUser->role !== 'superadmin' && 
            ($authUser->role !== 'admin' || $targetUser->role === 'superadmin' || $targetUser->id === $authUser->id)) {
            return response()->json([
                'message' => 'Unauthorized access to update this user'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|in:user,admin,superadmin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update user data
        $updateData = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $targetUser->update($updateData);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $targetUser
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id, Request $request)
    {
        $authUser = $request->user();
        $targetUser = User::findOrFail($id);
        
        // Check if the authenticated user has permission to delete this user
        if ($authUser->role !== 'superadmin' || $targetUser->role === 'superadmin') {
            return response()->json([
                'message' => 'Unauthorized access to delete this user. Only superadmins can delete users, and superadmins cannot delete other superadmins.'
            ], 403);
        }
        
        // Don't delete self
        if ($authUser->id === $targetUser->id) {
            return response()->json([
                'message' => 'You cannot delete your own account'
            ], 400);
        }
        
        $targetUser->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}