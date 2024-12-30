<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    protected $fillable = ['country_id', 'bank_name'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
