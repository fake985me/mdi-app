<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRecord extends Model
{
    protected $table = 'returns';
    
    protected $fillable = [
        'loan_id',
        'return_date',
        'condition',
        'notes',
    ];
    
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
