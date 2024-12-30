<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'income_tax_rate', 'use_real_time_conversion', 'converted_currency_quota'];

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }
}
