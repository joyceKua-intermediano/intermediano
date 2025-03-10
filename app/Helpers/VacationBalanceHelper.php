<?php

namespace App\Helpers;

use App\Models\Contract;
use App\Models\VacationRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VacationBalanceHelper
{

    public static function getAccruedVacation()
    {
        $user = Auth::user();

        $contract = Contract::where('employee_id', $user->id)->where('contract_type', 'employee')->first();
        $vacationRequest = VacationRequest::where('employee_id', $user->id)->where('status', 'approved')->get();
        if (!$contract) {
            return 0;
        }
        $startDate = Carbon::parse($contract->start_date);
        $daysWorked = $startDate->diffInDays(now());
        $daysInYear = $startDate->isLeapYear() ? 366 : 365;
        $accruedVacationDays = (30 * $daysWorked) / $daysInYear;
        return $accruedVacationDays;
    }
    public static function getVacationBalance()
    {
        $totalVacationTaken = self::getTotalVacationTaken();

        $accruedVacationDays = self::getAccruedVacation();
        return $accruedVacationDays - $totalVacationTaken;
    }

    public static function getTotalVacationTaken(){
        $user = Auth::user();
        $vacationRequest = VacationRequest::where('employee_id', $user->id)->where('status', 'approved')->get();

        $totalVacationTaken = 0;

        foreach ($vacationRequest as $item) {
            $totalVacationTaken += $item->number_of_days;
        }
        
        return $totalVacationTaken;
    }
}
