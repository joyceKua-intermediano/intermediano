<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankingDetail extends Model
{

    protected $fillable = [
        'employee_id',
        'bank_name',
        'branch_name',
        'bank_code',
        'account_number',
        'account_type',
        'bank_account_currency'

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
