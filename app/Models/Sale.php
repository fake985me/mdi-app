<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sale extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'customer_id',
        'sale_date',
        'total_amount',
        'notes',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'sale_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who created this sale.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the customer for this sale.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the sale items for this sale.
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
