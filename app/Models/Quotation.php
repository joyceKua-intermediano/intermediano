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
        'consultant_id',
        'currency_name',
        'exchange_rate',
        'exchange_acronym',
        'gross_salary',
        'fee',
        'bank_fee',
        'bonus',
        'home_allowance',
        'transport_allowance',
        'medical_allowance',
        'internet_allowance',
        'legal_grafication',
        'capped_amount',
        'uvt_amount',
        'dependent',
        'is_payroll',
        'is_integral',
        'payroll_cost_medical_insurance',
        'cluster_name'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
