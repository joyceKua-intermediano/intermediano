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
        'severance_fund'
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
