<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Employee extends Authenticatable implements FilamentUser
{
    use SoftDeletes;

    protected $guard = 'employee';
    protected $fillable = ['name', 'email', 'password', 'company'];

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }

    public function documents()
    {
        return $this->hasMany(BankingDetail::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class, 'employee_id');
    }
    public function getAccruedVacation()
    {
        $contract = $this->contract;
        if (!$contract) {
            return 0;
        }

        $startDate = Carbon::parse($contract->start_date);
        $daysWorked = $startDate->diffInDays(Carbon::now());
        $daysInYear = $startDate->isLeapYear() ? 366 : 365;
        $accruedVacationDays = (30 * $daysWorked) / $daysInYear;

        return $accruedVacationDays;
    }
    public function getTakenVacation(): float
    {
        return $this->vacationRequests()
            ->where('status', 'approved')
            ->sum('number_of_days');
    }
    public function getVacationBalance(): float
    {
        return $this->getAccruedVacation() - $this->getTakenVacation();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() == 'employee';
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
