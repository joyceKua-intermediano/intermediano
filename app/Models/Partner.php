<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'partner_type',
        'partner_name',
        'contact_name',
        'mobile_number',
        'tax_id',
        'email',
        'address'    
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
