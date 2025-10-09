<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = [
        'key_name',
        'value',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    protected $table = 'page_settings';
}