<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    protected $fillable = ['start_date', 'end_date', 'number_of_days', 'employee_id'];
    

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
