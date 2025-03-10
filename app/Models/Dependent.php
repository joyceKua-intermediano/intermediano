<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{

    protected $fillable = [
        'employee_id',
        'full_name',
        'relationship',
        'date_of_birth',
        'tax_id',

    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class);
    }
}
