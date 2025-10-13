<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationItem extends Model
{
    protected $fillable = [
        'name',
        'path',
        'slug',
        'parent_id',
        'sort_order',
        'is_active',
        'is_public',
        'metadata'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'metadata' => 'array'
    ];

    // Relasi untuk navigasi bersarang
    public function parent()
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->orderBy('sort_order');
    }

    // Scope untuk hanya mengambil item navigasi aktif dan publik
    public function scopeActivePublic($query)
    {
        return $query->where('is_active', true)->where('is_public', true)->orderBy('sort_order');
    }

    // Scope untuk mengambil hanya item tingkat atas
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
