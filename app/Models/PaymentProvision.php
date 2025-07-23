<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProvision extends Model
{
    protected $fillable = [
        'quotation_id',
        'provision_type_id',
        'country_id',
        'cluster_name',
        'amount',
    ];

    public function provisionType()
    {
        return $this->belongsTo(ProvisionType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

}
