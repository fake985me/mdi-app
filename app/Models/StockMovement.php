<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StockMovement extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'movement_type',
        'quantity',
        'unit_price',
        'total_amount',
        'notes',
        'created_by',
    ];

    public $timestamps = false;
    const UPDATED_AT = null;
    
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
    
    protected $dates = ['created_at'];

    /**
     * Get the product associated with this stock movement.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Get the user who created this stock movement.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'created_by', 'id');
    }
}
