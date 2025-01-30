<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntermedianoCompany extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'contact_name', 'mobile_number', 'email', 'address', 'tax_id', 'country_id'];

    public function country() 
    {
        return $this->belongsTo(Country::class);
    }

}
