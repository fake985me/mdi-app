<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')
            ->paginate(request('per_page', 10));
        
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:superadmin,admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
        ]);

        // Assign the role to the user
        $user->assignRole($request->role);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select('id', 'name', 'email', 'role', 'phone', 'address', 'created_at', 'updated_at')
            ->findOrFail($id);
        
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:superadmin,admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Reassign the role to the user
        $user->syncRoles([$request->role]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting the current user
        if ($user->id === request()->user()->id) {
            return response()->json(['message' => 'Cannot delete yourself'], 422);
        }
        
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
    
    /**
     * Assign a role to a user.
     */
    public function assignRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $role = Role::where('name', $request->role)->first();
        
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 422);
        }
        
        $user->syncRoles([$request->role]);
        
        return response()->json(['message' => 'Role assigned successfully']);
    }
}
