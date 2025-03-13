<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{

    protected $fillable = [
        'employee_id',
        'civil_status',
        'date_of_birth',
        'is_local',
        'work_visa',
        'residence',
        'country',
        'state',
        'address',
        'postal_code',
        'phone',
        'mobile',
        'education_attainment',
        'education_status',
        'number_of_dependents'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }
}
