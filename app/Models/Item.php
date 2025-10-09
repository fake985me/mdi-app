<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'subcategory_id',
        'brand_id',
        'description',
        'specifications',
        'price',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'subcategory_id' => 'integer',
        'brand_id' => 'integer',
        'specifications' => 'array', // JSON will be cast to array
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function itemImages(): HasMany
    {
        return $this->hasMany(ItemImage::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function warranties(): HasMany
    {
        return $this->hasMany(Warranty::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Helper method to get current stock
    public function getCurrentStockAttribute(): int
    {
        $stockIn = $this->stockMovements()
            ->where('type', 'masuk')
            ->sum('quantity');
        
        $stockOut = $this->stockMovements()
            ->where('type', 'keluar')
            ->sum('quantity');
            
        return $stockIn - $stockOut;
    }
}