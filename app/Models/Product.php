<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price',
        'cost_price',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
        'sku',
        'category_id',
        'subcategory_id',
        'image_url',
        'status',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'price' => 'decimal:2',
        'current_stock' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory that owns the product.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the orders for this product.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}