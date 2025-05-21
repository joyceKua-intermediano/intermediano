<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplementaryContractDetails extends Model
{
    protected $fillable = [
        'standard_working_hours',
        'shift_schedule',
        'notice_period',
        'payment_terms',
        'billing_currency',
        'payment_currency',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
