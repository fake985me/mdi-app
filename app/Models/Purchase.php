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
        'supplier_name',
        'supplier_contact',
        'purchase_date',
        'total_amount',
        'notes',
        'created_by',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'purchase_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who created this purchase.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'created_by', 'id');
    }
}
