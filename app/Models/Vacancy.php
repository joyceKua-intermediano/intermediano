<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function company () {
        return $this->belongsTo(Company::class);
    }

    public function contact () {
        return $this->belongsTo(Contact::class);
    }

    public function allowances () {
        return $this->hasMany(VacancyAllowance::class);
    }

    public function skills () {
        return $this->hasMany(VacancySkill::class);
    }

    public function languages () {
        return $this->hasMany(VacancyLanguage::class);
    }
}
