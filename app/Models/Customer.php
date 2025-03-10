<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use SoftDeletes;

    protected $guard = 'customer';
    protected $fillable = ['name', 'email', 'password', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
