<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'cluster',
        'employee_id',
        'payslip_period',
        'file_name',
        'file_path',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
