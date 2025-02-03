<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryAnnualSetup extends Model
{
    use SoftDeletes;

    protected $fillable = [
     'country_id',
     'year',
     'uvt_amount',
     'capped_amount'
    ];

    public function country() {
        return $this->belongsTo(Country::class);
    }
}
