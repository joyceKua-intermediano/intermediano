@php
    $quotationDetails = calculateFreelanceQuotation($record, []);
    $intermedianoCompany = preg_replace('/(?<!^)([A-Z])/', ' $1', $record->cluster_name);
@endphp

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800"> {{ str_replace('/', '.', $record->title) }} quotation for
        {{ $intermedianoCompany }} - {{ $record->is_payroll ? $record->consultant->name : '' }} </h3>
    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Gross Salary</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['grossSalary'], 2) }}</span>

        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Gross Income</span>
            <span class="text-gray-800 w-1/5  text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['totalGrossIncome'] / $record->exchange_rate, 2) }}</span>

        </div>
        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Fee</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['fee'] / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Bank Fee</span>
            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['bankFee'], 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Invoice</span>
            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }} {{ number_format($quotationDetails['totalInvoice'] / $record->exchange_rate, 2) }}</span>
        </div>

    </div>
</div>


