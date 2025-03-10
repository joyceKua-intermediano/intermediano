<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankingDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'document_type',
        'file_path',

    ];
    // protected $casts = [
    //     'dependents' => 'array', // Cast to array
    // ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function document()
    {
        return $this->belongsTo(BankingDetail::class);
    }
}
