<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancyAllowance extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function vacancy () {
        return $this->belongsTo(Vacancy::class);
    }

}
