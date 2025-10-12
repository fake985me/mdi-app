<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'content',
        'settings',
        'custom_css',
        'custom_js',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'custom_css' => 'array',
        'custom_js' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}