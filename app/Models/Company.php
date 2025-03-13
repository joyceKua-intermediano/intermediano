<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $appends = ["main_contact", "contact_fullname"];

    protected static function booted(): void
    {
        static::created(function (Model $model) {

            if (session('leadId')) {
                $lead = Lead::find(session('leadId'));
                $lead->company_id = $model->id;
                $lead->save();
    
                // clean lead
                session()->forget('leadId');
            }
            
        });
    }

    public function leads () {
        return $this->hasMany(Lead::class);
    }

    public function contacts () {
        return $this->hasMany(Contact::class)->orderByDesc('is_main_contact');
    }

    public function getMainContactAttribute () {
        return Contact::whereCompanyId($this->id)->where("is_main_contact", 1)->first();
    }

    public function industry_field () {
        return $this->belongsTo(IndustryField::class);
    }

    public function getContactFullnameAttribute () {
        $main_contact = Contact::whereCompanyId($this->id)->where("is_main_contact", 1)->first();
        return $main_contact?->contact_name . " " . $main_contact?->surname;
    }
    public function mspPayrolls()
    {
        return $this->belongsToMany(MspPayroll::class, 'msp_payroll_company');
    }
    
    public  function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
