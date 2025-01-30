<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultant extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',    
        'email',    
        'mobile_number',    
        'country_id',
        'address',
        'employeer'

    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function company()
    {
        return $this->belongsTo(IntermedianoCompany::class);
    }
}
