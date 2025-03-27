<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyTimesheet extends Model
{
    // Timesheet.php
    protected $fillable = ['employee_id', 'year', 'month', 'days', 'total_hours', 'status', 'comment'];

    protected $casts = [
        'days' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_hours = array_sum($model->days ?? []);

            if (is_null($model->days)) {
                $model->days = array_fill(1, 31, 0);
            }

            if (auth()->check() && !$model->employee_id) {
                $model->employee_id = auth()->id();
            }
        });
    }

    public function getMonthYearAttribute()
    {
        return \Carbon\Carbon::create($this->year, $this->month)->format('F Y');
    }
}
