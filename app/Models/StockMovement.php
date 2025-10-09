<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'item_id',
        'type',
        'quantity',
        'reference_type',
        'reference_id',
        'date',
        'description',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'quantity' => 'integer',
        'date' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    // Define constants for types
    const TYPE_IN = 'masuk';
    const TYPE_OUT = 'keluar';
}