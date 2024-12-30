<?php

namespace App\Models;

use App\Enums\LeadStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    // status

    public const LEAD_STATUS = [
        LeadStatusEnum::Presentation->value => LeadStatusEnum::Presentation->value,
        LeadStatusEnum::NeedAnalysis->value => LeadStatusEnum::NeedAnalysis->value,
        LeadStatusEnum::PricingSubmitted->value => LeadStatusEnum::PricingSubmitted->value,
        LeadStatusEnum::PricingNegociation->value => LeadStatusEnum::PricingNegociation->value,
        LeadStatusEnum::Negotiation->value => LeadStatusEnum::Negotiation->value,
        LeadStatusEnum::MSA_Princing_Review->value => LeadStatusEnum::MSA_Princing_Review->value,
        LeadStatusEnum::ClosedWon->value => LeadStatusEnum::ClosedWon->value,
        LeadStatusEnum::ClosedCancelled->value => LeadStatusEnum::ClosedCancelled->value,
        LeadStatusEnum::ClosedLost->value => LeadStatusEnum::ClosedLost->value
    ];

    public const OPPORTUNITY_TYPES = [
        "MSP" => "MSP",
        "CMO Global" => "CMO Global",
        "CMO Regional" => "CMO Regional",
        "Other" => "Other"
    ];

    public const LEAD_STATUS_WITH_REASON =  [LeadStatusEnum::ClosedCancelled->value, LeadStatusEnum::ClosedLost->value];

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            $company = Company::find($lead->company_id);
            $lead->opportunity_name = $company?->name;
        });

        static::updating(function (Model $model) {
            $notAllowedStatus = [LeadStatusEnum::ClosedCancelled->value, LeadStatusEnum::ClosedLost->value, "Closed"];
            $lead = Lead::find($model->id);

            if (in_array($model->lead_status, $notAllowedStatus) && !$model->close_reason) {
                $model->lead_status = $lead->lead_status;
                $model->close_reason = NULL;
            } else if (!in_array($model->lead_status, $notAllowedStatus)) {
                $model->close_reason = NULL;
            }
        });
    }

    public function owner() {
        return $this->belongsTo(User::class, "opportunity_owner");
    }

    public function company () {
        return $this->belongsTo(Company::class);
    }

    public function contact () {
        return $this->belongsTo(Contact::class);
    }

    public function getTitleAttribute () {

        $status = $this->lead_status; 

        $symbol = "";
        if ($status == LeadStatusEnum::ClosedWon->value) {
            $symbol = "<div style='height:30px;background:#C7FFD8; border-radius:12px; display:flex;align-items:center;padding:0 10px; margin-right: 10px'>". __('Closed won') ."</div>";
        } else if ($status == LeadStatusEnum::ClosedCancelled->value) {
            $symbol = "<div style='height:30px;background:#FFF7F1; border-radius:12px; display:flex;align-items:center;padding:0 10px; margin-right: 10px'>". __('Closed Cancelled') ." </div>";
        } else if ($status == LeadStatusEnum::ClosedLost->value) {
            $symbol = "<div style='height:30px;background:#FFECC8; border-radius:12px; display:flex;align-items:center;padding:0 10px; margin-right: 10px'>". __('Closed Lost') ."</div>";
        }

        $image = "";
        $imageUrl = "";
        if ($this->owner) {
            $imageUrl = $this->onwer?->avatar_url ? "/storage/" . $this->onwer?->avatar_url : "https://gravatar.com/avatar/82820590931dda645a358e6d7a6cae17?s=400&d=mp&r=x";
            $image = "<img src='$imageUrl' style='width:30px; height:30px; object-fit:cover; border: 1px solid #ddd; border-radius:50%; margin-right: 10px'/ > " . $this->owner?->name;
        } 
        return "<strong>#" . $this->id . "</strong> - "
         . $this->lead . "<div style='display:flex;flex-direction:column; font-size:10px; margin-top:12px;'> 
         $symbol <span style='display:flex;flex-direction:row; align-items:center; font-size:10px; margin-top:12px;'>$image</span> </div>
        ";
    }
}
