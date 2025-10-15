<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Borrowing extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'customer_id',
        'user_id',
        'quantity',
        'borrow_date',
        'expected_return_date',
        'actual_return_date',
        'status',
        'notes',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'borrow_date' => 'datetime',
        'expected_return_date' => 'datetime',
        'actual_return_date' => 'datetime',
        'quantity' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the product associated with this borrowing.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Get the customer associated with this borrowing.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the user who created this borrowing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
