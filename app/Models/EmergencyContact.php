<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'employee_id',
        'emergency_contact_name',
        'relationship',
        'mobile_number',
        'email',
    ];
    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'employee_id');
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
