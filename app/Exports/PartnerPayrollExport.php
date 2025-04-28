<?php

namespace App\Exports;

use App\Models\Consultant;
use App\Models\Country;
use App\Models\MspPayroll;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PartnerPayrollExport implements FromView
{
    protected $record;
    public function __construct($record)
    {
        $this->record = $record;
    }
    public function view(): View
    {
        $data =  $this->record->data;
        $filteredData = [];
        foreach ($data as &$item) {
            $country = Country::find($item['country_id']); 
            $consultant = Consultant::find($item['consultant_id']); 
            $item['consultant_name'] = $consultant ? $consultant->name : 'Unknown';
            $item['country_name'] = $country ? $country->name : 'Unknown';

            foreach ($this->record->companies as $company) {
                if ($company->name == 'Wesco Anixter USVI, LLC' && $item['country_name'] == 'USVI') {
                    
                    $filteredData[] = $item;
                } elseif ($company->name == 'WESCO DISTRIBUTION INC.' && $item['country_name'] != 'USVI') {
                    $filteredData[] = $item;
                }
            }
        }
        $exportFile = 'exports.payroll.uruguay';
        return view($exportFile, [
            'record' => $this->record,
            'data' => $filteredData,
        ]);
    }
    
}
