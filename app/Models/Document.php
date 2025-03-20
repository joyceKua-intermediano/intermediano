<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $fillable = [
        'employee_id',
        'personal_id',
        'tax_id',
        'organism',
        'expiration',
        'other',
        'is_driver_license',
        'has_insurance',
        'category',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function bankingDetail()
    {
        return $this->hasOne(BankingDetail::class);
    }

    public function employeeFiles()
    {
        return $this->hasMany(EmployeeFile::class);
    }

    public function socialSecurityInfos()
    {
        return $this->hasMany(SocialSecurityInfo::class);
    }
}
