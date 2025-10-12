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
        'customer_name',
        'customer_contact',
        'sale_date',
        'total_amount',
        'notes',
        'created_by',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'sale_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who created this sale.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'created_by', 'id');
    }
}
