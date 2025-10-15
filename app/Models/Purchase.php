<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Purchase extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'purchase_date',
        'total_amount',
        'notes',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'purchase_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who created this purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the supplier for this purchase.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Get the purchase items for this purchase.
     */
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
