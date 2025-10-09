<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warranty extends Model
{
    protected $fillable = [
        'item_id',
        'warranty_number',
        'start_date',
        'end_date',
        'terms',
        'status',
        'notes',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}