<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'specifications' => $this->specifications,
            'sku' => $this->sku,
            'image' => $this->image,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'subcategory' => new SubcategoryResource($this->whenLoaded('subcategory')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}