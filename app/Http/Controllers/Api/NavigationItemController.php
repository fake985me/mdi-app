<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NavigationItemController extends Controller
{
    /**
     * Display a listing of the navigation items.
     */
    public function index(): JsonResponse
    {
        $navigationItems = NavigationItem::with('children')
            ->topLevel()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $navigationItems
        ]);
    }

    /**
     * Get all active public navigation items (for public display).
     */
    public function getActivePublicNavigation(): JsonResponse
    {
        $navigationItems = NavigationItem::activePublic()
            ->topLevel()
            ->with(['children' => function($query) {
                $query->activePublic();
            }])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $navigationItems
        ]);
    }

    /**
     * Store a newly created navigation item in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'path' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:navigation_items,slug',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $navigationItem = NavigationItem::create($request->all());

        return response()->json([
            'message' => 'Navigation item created successfully',
            'data' => $navigationItem
        ], 201);
    }

    /**
     * Display the specified navigation item.
     */
    public function show(string $id): JsonResponse
    {
        $navigationItem = NavigationItem::with('parent', 'children')->findOrFail($id);

        return response()->json([
            'data' => $navigationItem
        ]);
    }

    /**
     * Update the specified navigation item in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $navigationItem = NavigationItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'path' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:navigation_items,slug,' . $id,
            'parent_id' => 'nullable|exists:navigation_items,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'metadata' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $navigationItem->update($request->all());

        return response()->json([
            'message' => 'Navigation item updated successfully',
            'data' => $navigationItem
        ]);
    }

    /**
     * Remove the specified navigation item from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $navigationItem = NavigationItem::findOrFail($id);
        $navigationItem->delete();

        return response()->json([
            'message' => 'Navigation item deleted successfully'
        ]);
    }
}
