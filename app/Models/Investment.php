<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['country_id', 'bank_id', 'currency_id', 'capital', 'rate_type', 'interest_rate', 'deposit_date', 'withdrawal_period'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
