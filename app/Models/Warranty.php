<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Warranty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'warranty_start_date',
        'warranty_end_date',
        'warranty_terms',
        'customer_name',
        'customer_contact',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'warranty_start_date' => 'datetime',
        'warranty_end_date' => 'datetime',
    ];

    /**
     * Get the product associated with this warranty.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
