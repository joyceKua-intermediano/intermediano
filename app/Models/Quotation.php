<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'company_id',
        'country_id',
        'currency_name',
        'exchange_rate',
        'exchange_acronym',
        'gross_salary',
        'fee',
        'bonus',
        'home_allowance',
        'transport_allowance',
        'medical_allowance',
        'legal_grafication',
        'capped_amount',
        'uvt_amount',
        'dependent',
        'cluster_name'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function company()
    {
        return $this->belongsTo(IntermedianoCompany::class);
    }
}
