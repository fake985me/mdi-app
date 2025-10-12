<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the templates.
     */
    public function index(): JsonResponse
    {
        $templates = Template::orderBy('sort_order')->get();
        
        return response()->json([
            'data' => $templates
        ]);
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:templates,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'category' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template = Template::create($request->all());

        return response()->json([
            'message' => 'Template created successfully',
            'data' => $template
        ], 201);
    }

    /**
     * Display the specified template.
     */
    public function show(string $id): JsonResponse
    {
        $template = Template::findOrFail($id);
        
        return response()->json([
            'data' => $template
        ]);
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $template = Template::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:templates,slug,' . $id,
            'description' => 'nullable|string',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'category' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template->update($request->all());

        return response()->json([
            'message' => 'Template updated successfully',
            'data' => $template
        ]);
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return response()->json([
            'message' => 'Template deleted successfully'
        ]);
    }

    /**
     * Get active templates in a specific category
     */
    public function getByCategory(string $category): JsonResponse
    {
        $templates = Template::where('category', $category)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return response()->json([
            'data' => $templates
        ]);
    }

    /**
     * Get all active templates
     */
    public function getActive(): JsonResponse
    {
        $templates = Template::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return response()->json([
            'data' => $templates
        ]);
    }
}
