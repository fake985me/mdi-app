<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Return extends Model
{
    protected $fillable = [
        'loan_id',
        'return_date',
        'condition',
        'notes',
    ];

    protected $casts = [
        'loan_id' => 'integer',
        'return_date' => 'date',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}