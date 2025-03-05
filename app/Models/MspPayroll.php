<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MspPayroll extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'data', 
        'title', 
        'company_ids', 
        'bank_fee', 
        'fee', 
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'msp_payroll_company');
    }

}