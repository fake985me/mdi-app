<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category', 'subcategory', 'brand', 'images'])
            ->paginate(request('per_page', 10));
        
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:items,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = Item::create($validator->validated());

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with(['category', 'subcategory', 'brand', 'images'])->findOrFail($id);
        
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item->update($validator->validated());

        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        
        // Delete associated images first
        $item->images()->delete();
        
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
    
    /**
     * Upload an image for an item.
     */
    public function uploadImage(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_primary' => 'boolean',
            'order' => 'integer'
        ]);
        
        $imagePath = $request->file('image')->store('items', 'public');
        
        $image = $item->images()->create([
            'image_path' => $imagePath,
            'is_primary' => $request->is_primary ?? false,
            'order' => $request->order ?? 0,
        ]);
        
        return response()->json($image, 201);
    }
    
    /**
     * Delete an image from an item.
     */
    public function deleteImage($id, $imageId)
    {
        $item = Item::findOrFail($id);
        $image = ItemImage::where('item_id', $item->id)->findOrFail($imageId);
        
        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();
        
        return response()->json(['message' => 'Image deleted successfully']);
    }
    
    /**
     * Display a listing of the resource for guest users.
     */
    public function guestIndex()
    {
        $items = Item::with(['category', 'subcategory', 'brand', 'images'])
            ->whereHas('stockMovements', function ($query) {
                $query->select(DB::raw('item_id, SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock'))
                      ->groupBy('item_id')
                      ->havingRaw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) > 0');
            })
            ->paginate(request('per_page', 10));
        
        return response()->json($items);
    }
    
    /**
     * Display the specified resource for guest users.
     */
    public function guestShow(string $id)
    {
        $item = Item::with(['category', 'subcategory', 'brand', 'images'])->findOrFail($id);
        
        // Calculate current stock
        $stock = $item->stockMovements()
            ->select(DB::raw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock'))
            ->first()->net_stock ?? 0;
        
        $item->current_stock = $stock;
        
        return response()->json($item);
    }
}
