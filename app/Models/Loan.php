<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'item_id',
        'borrower',
        'loan_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function returnRecords()
    {
        return $this->hasMany(ReturnRecord::class);
    }
    
    public function returns()
    {
        return $this->hasMany(Return::class);
    }
}