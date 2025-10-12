<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subcategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'slug',
        'status',
    ];

    public $timestamps = true;
    
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the category that owns the subcategory.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the products for this subcategory.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}