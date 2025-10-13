<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index(): JsonResponse
    {
        $pages = Page::orderBy('sort_order')->get();
        
        return response()->json([
            'data' => $pages
        ]);
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'custom_css' => 'nullable|array',
            'custom_js' => 'nullable|array',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate slug if not provided
        $slug = $request->slug ?? Str::slug($request->title);
        
        $page = Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'featured_image' => $request->featured_image,
            'content' => $request->content ?? [],
            'settings' => $request->settings ?? [],
            'custom_css' => $request->custom_css ?? [],
            'custom_js' => $request->custom_js ?? [],
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return response()->json([
            'message' => 'Page created successfully',
            'data' => $page
        ], 201);
    }

    /**
     * Display the specified page.
     */
    public function show(string $id): JsonResponse
    {
        $page = Page::findOrFail($id);
        
        return response()->json([
            'data' => $page
        ]);
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $page = Page::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:pages,slug,' . $id,
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'custom_css' => 'nullable|array',
            'custom_js' => 'nullable|array',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $page->update($request->all());

        return response()->json([
            'message' => 'Page updated successfully',
            'data' => $page
        ]);
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ]);
    }
    

    
    /**
     * Get the home page content
     */
    public function getHomePage(): JsonResponse
    {
        // Try to get a page with slug 'home'
        $homePage = Page::where('slug', 'home')->where('is_active', true)->first();
        
        if ($homePage) {
            return response()->json([
                'data' => $homePage
            ]);
        }
        
        // If no home page exists, return an empty page as fallback
        $emptyPage = [
            'id' => null,
            'title' => 'Home',
            'slug' => 'home',
            'content' => [],
            'settings' => [],
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        return response()->json([
            'data' => $emptyPage
        ]);
    }



    /**
     * Get page by slug for public access
     * If the parameter looks like an ID (numeric) and user is authenticated, handle it as an ID lookup
     */
    public function getBySlug(string $slug): JsonResponse
    {
        // Check if this is actually a numeric ID (for authenticated users accessing by ID)
        if (auth()->check() && is_numeric($slug)) {
            $page = Page::find($slug);
            if ($page) {
                return response()->json([
                    'data' => $page
                ]);
            }
            // If no page found by ID, continue with slug lookup (though unlikely for numeric IDs)
        }
        
        // Otherwise, treat as a slug lookup (public access)
        $page = Page::where('slug', $slug)->where('is_active', true)->where('is_public', true)->first();
        
        if (!$page) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }
        
        return response()->json([
            'data' => $page
        ]);
    }

    /**
     * Get all active public pages
     */
    public function getActivePublicPages(): JsonResponse
    {
        $pages = Page::where('is_active', true)
                    ->where('is_public', true)
                    ->orderBy('sort_order')
                    ->get();

        return response()->json([
            'data' => $pages
        ]);
    }
}