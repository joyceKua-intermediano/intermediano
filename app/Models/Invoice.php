<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['employee_id', 'company_id', 'invoice_date', 'invoice_items', 'cluster_name'];

    protected $casts = [
        'invoice_items' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
