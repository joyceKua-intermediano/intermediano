@php
    $quotationDetails = calculateEcuadorQuotation($record, []);
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

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Payroll Costs</span>

            <span class="text-gray-800 w-1/5 text-right"> {{ $record->currency_name }}
                {{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Provisions</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</span>

        </div>


        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Subtotal Gross Salary + Payroll Costs</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['subTotalGrossPayroll'] / $record->exchange_rate, 2) }}</span>
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

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Subtotal</span>
            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['subTotal'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between bg-gray-200 p-2">
            <span class="font-medium w-2/5">Municipal tax - ICA 1%</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['municipalTax'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Service taxes - VAT 19%</span>
            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['servicesTaxes'] / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Invoice</span>

            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['totalInvoice'] / $record->exchange_rate, 2) }}</span>
        </div>

    </div>
</div>

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800">Payroll Costs</h3>

    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">I.E.S.S. Instituto Ecuatoriano de Seguridad Social</span>

            <span class="text-gray-800"> {{ $record->currency_name }}
                {{ number_format($quotationDetails['iess'], 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">SECAP Ecuadorian Training Service</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['secap'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">IECE Ecuadorian Institute of Education and Educational
                Credit</span>
            <span class="text-gray-800"> {{ $record->currency_name }}
                {{ number_format($quotationDetails['iece'], 2) }}</span>

        </div>
        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}</span>
        </div>
    </div>
</div>

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800">Provisions</h3>

    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 	w-2/5">Vacation</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['vacation'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Reserve Fund</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['reserveFund'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Bonus 13th</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['bonus13th'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Bonus 14th</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['bonus14th'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">25% Bonification</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['bonification'], 2) }}</span>

        </div>
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Compensation</span>
            <span class="text-gray-800">{{ $record->currency_name }}
                {{ number_format($quotationDetails['compensation'], 2) }}</span>
        </div>
        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total</span>
            <span class="text-gray-800 w-1/5 text-right">{{ $record->currency_name }}
                {{ number_format($quotationDetails['provisionsTotal'], 2) }}</span>
        </div>
    </div>
</div>
