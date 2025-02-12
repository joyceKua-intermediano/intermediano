<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollCost extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'medical_insurance',
        'meal',
        'transportation'
    ];

    public function quotation(): BelongsTo 
    {
        return $this->belongsTo(Quotation::class);
    }
}
