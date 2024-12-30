<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $appends = ["fullname"];

    public function company () {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        static::updating(function (Model $model) {
            if ($model->is_main_contact && $model->company_id) {
                DB::table('contacts')->where('id', '!=', $model->id)->whereCompanyId($model->company_id)->update(["is_main_contact" => 0]);
            }
        });
    }

    public function getFullnameAttribute () {
        return $this->contact_name . " " . $this->surname;
    }
}
