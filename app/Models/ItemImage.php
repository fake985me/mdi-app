<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemImage extends Model
{
    protected $fillable = [
        'item_id',
        'image_path',
        'is_primary',
        'order_position',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'is_primary' => 'boolean',
        'order_position' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}