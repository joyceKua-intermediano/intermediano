<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeExpenses extends Model
{
    protected $fillable = [
        'expenses',
        'employee_id',
        'company_id',
        'created_by',
        'status',
        'cost_center',
        'type',
        'currency_name'
    ];

    protected $casts = [
        'expenses' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->allExpensesApproved()) {
                $model->status = 'approved';
            }
        });
    }

    public function allExpensesApproved(): bool
    {

        // Check if all items in the `expenses` array have status `approved`
        return collect($this->expenses)->every(fn($expense) => $expense['status'] === 'approved');
    }
}
