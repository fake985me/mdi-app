<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingPageSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LandingPageSettingController extends Controller
{
    /**
     * Display a listing of the landing page sections.
     */
    public function index(): JsonResponse
    {
        $sections = LandingPageSetting::orderBy('sort_order')->get();
        
        return response()->json([
            'data' => $sections
        ]);
    }

    /**
     * Store a newly created landing page section in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|string|max:255',
            'section_type' => 'required|in:hero,features,testimonials,products,carousel,slider,grid,cta,navigation,footer',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $section = LandingPageSetting::create($request->all());

        return response()->json([
            'message' => 'Landing page section created successfully',
            'data' => $section
        ], 201);
    }

    /**
     * Display the specified landing page section.
     */
    public function show(string $id): JsonResponse
    {
        $section = LandingPageSetting::findOrFail($id);
        
        return response()->json([
            'data' => $section
        ]);
    }

    /**
     * Update the specified landing page section in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $section = LandingPageSetting::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section_name' => 'sometimes|required|string|max:255',
            'section_type' => 'sometimes|required|in:hero,features,testimonials,products,carousel,slider,grid,cta,navigation,footer',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $section->update($request->all());

        return response()->json([
            'message' => 'Landing page section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Remove the specified landing page section from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $section = LandingPageSetting::findOrFail($id);
        $section->delete();

        return response()->json([
            'message' => 'Landing page section deleted successfully'
        ]);
    }

    /**
     * Get active landing page sections in order
     */
    public function getActiveSections(): JsonResponse
    {
        \Log::info('getActiveSections called');
        
        try {
            $sections = LandingPageSetting::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            
            \Log::info('getActiveSections query successful', ['count' => $sections->count()]);
            
            return response()->json([
                'data' => $sections
            ]);
        } catch (\Exception $e) {
            \Log::error('getActiveSections error', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
    
    /**
     * Public endpoint for active landing page sections
     */
    public function publicActiveSections(): JsonResponse
    {
        \Log::info('publicActiveSections called');
        
        try {
            $sections = LandingPageSetting::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            
            \Log::info('publicActiveSections query successful', ['count' => $sections->count()]);
            
            return response()->json([
                'data' => $sections
            ]);
        } catch (\Exception $e) {
            \Log::error('publicActiveSections error', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}