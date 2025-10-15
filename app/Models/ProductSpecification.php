<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'spec_name',
        'spec_value',
        'sort_order',
    ];

    public $timestamps = true;

    /**
     * Get the product that owns this specification.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}