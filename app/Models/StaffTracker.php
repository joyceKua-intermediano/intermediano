<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffTracker extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'consultant_id',  
      'country_id',  
      'position',  
      'industry_field_id',
      'intermediano_company_id',
      'company_id',
      'partner_id',
      'start_date',
      'end_date',
      'status',
    ];

    public function consultant(): BelongsTo {
        return $this->belongsTo(Consultant::class);
    }

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class);
    }

    public function industry_field(): BelongsTo {
        return $this->belongsTo(IndustryField::class);
    }

    public function intermedianoCompany(): BelongsTo {
        return $this->belongsTo(IntermedianoCompany::class);
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function partner(): BelongsTo {
        return $this->belongsTo(Partner::class);
    }
}
