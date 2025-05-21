<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $fillable = [
        'contact_person',
        'email',
        'mobile_number',
        'invoice_number',
        'invoice_cycle',
        'invoice_deadline',
        'currency_payment',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
