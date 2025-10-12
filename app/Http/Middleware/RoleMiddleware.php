<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Authentication required'
            ], 401);
        }

        $user = Auth::user();
        
        // Check if the user has the required role through their profile
        $profile = $user->profile;
        
        if (!$profile || $profile->role !== $role) {
            return response()->json([
                'message' => 'Access denied. Required role: ' . $role
            ], 403);
        }

        return $next($request);
    }
}