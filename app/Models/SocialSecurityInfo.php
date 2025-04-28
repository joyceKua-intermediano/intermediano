<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialSecurityInfo extends Model
{
    protected $fillable = 
    [
        'employee_id',
        'health_fund',
        'pension_fund',
        'severance_fund',
        'social_security_number',
        'health_fund_file',
        'pension_fund_file',
        'severance_fund_file',
        'social_security_file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
