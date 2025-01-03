<?php

namespace App\Models;

use Carbon\Carbon;
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
    protected static function booted()
    {
        static::creating(function ($investment) {
            $investment->year = Carbon::parse($investment->deposit_date)->year;
        });
    }
}
