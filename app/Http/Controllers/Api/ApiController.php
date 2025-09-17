<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Success response method
     * 
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success($data = null, $message = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error response method
     * 
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @return JsonResponse
     */
    public function error($message = 'Error', $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Get the authenticated user
     * 
     * @return \App\Models\User|null
     */
    protected function getUser()
    {
        return Auth::user();
    }

    /**
     * Check if the user is authenticated
     * 
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Check if the user is a super admin
     * 
     * @return bool
     */
    protected function isSuperAdmin(): bool
    {
        $user = $this->getUser();
        return $user && $user->isSuperAdmin();
    }
}