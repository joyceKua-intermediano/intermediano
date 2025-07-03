<?php

namespace App\Models;

use App\Filament\Resources\VacancyResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'employee_id',
        'quotation_id',
        'country_work',
        'job_title',
        'start_date',
        'end_date',
        'gross_salary',
        'contract_type',
        'job_description',
        'translated_job_description',
        'cluster_name',
        'signature',
        'signed_contract',
        'admin_signature',
        'admin_signed_contract',
        'is_integral',
        'partner_id',
        'intermediano_company_id',
        'admin_signed_by'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_signed_by');
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
    public function intermedianoCompany(): BelongsTo
    {
        return $this->belongsTo(IntermedianoCompany::class);
    }
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function personalInformation(): BelongsTo
    {
        return $this->belongsTo(PersonalInformation::class, 'employee_id', 'employee_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'employee_id', 'employee_id');
    }

    public function companyContact(): HasOneThrough
    {
        return $this->hasOneThrough(
            Contact::class,
            Company::class,
            'id',
            'company_id',
            'company_id',
            'id'
        );
    }

    public function vacationRequest()
    {
        return $this->hasMany(VacancyResource::class);
    }

    public function socialSecurityInfos(): BelongsTo
    {
        return $this->belongsTo(SocialSecurityInfo::class, 'employee_id', 'employee_id');
    }

    public function supplementaryContractDetails()
    {
        return $this->hasOne(SupplementaryContractDetails::class);
    }
}
