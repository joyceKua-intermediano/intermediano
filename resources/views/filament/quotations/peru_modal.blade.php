@php
    $quotationDetails = calculatePeruQuotation($record, []);
    $intermedianoCompany =preg_replace('/(?<!^)([A-Z])/', ' $1', $record->cluster_name);
@endphp

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800"> {{ str_replace('/', '.', $record->title) }} quotation for
        {{ $intermedianoCompany }}  - {{ $record->is_payroll ? $record->consultant->name : '' }} (Ordinary) </h3>
    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Gross Salary</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['grossSalary'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['grossSalary'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Gross Income</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['totalGrossIncome'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5  text-right">USD {{ number_format($quotationDetails['totalGrossIncome'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Payroll Costs</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['payrollCostsTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Provisions</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['provisionsTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</span>

        </div>


        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Subtotal Gross Salary + Payroll Costs</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['subTotalGrossPayroll'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['subTotalGrossPayroll']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Fee</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['fee'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['fee']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Bank Fee</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['bankFee'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['bankFee'], 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Subtotal</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['subTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['subTotal']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Service taxes - VAT 19%</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['servicesTaxes'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['servicesTaxes']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Invoice</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['totalInvoice'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['totalInvoice']  / $record->exchange_rate, 2) }}</span>
        </div>

    </div>
</div>

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800">Payroll Costs</h3>

    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 	w-2/5">Health Insurance- Essalud</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['healthInsurance'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['healthInsurance']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Health Insurance- Essalud- Vacations</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['healthInsuranceVacation'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['healthInsuranceVacation']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">EPS</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['eps'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['eps']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">SEGURO VIDA LEY</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['seguroVida'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['seguroVida']  / $record->exchange_rate, 2) }}</span>
        </div>
        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['payrollCostsTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['payrollCostsTotal']  / $record->exchange_rate, 2) }}</span>
        </div>
    </div>
</div>

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800">Provisions</h3>

    <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 mt-4">
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 	w-2/5">Gratification</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['gratification'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['gratification']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Extraordinary Gratification</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['extraOrdinaryGratification'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['extraOrdinaryGratification']  / $record->exchange_rate, 2) }}</span>
        </div>
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Vacations</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['vacation'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['vacation']  / $record->exchange_rate, 2) }}</span>
        </div>
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">CTS</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['cts'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['cts']  / $record->exchange_rate, 2) }}</span>
        </div>
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Termination - Indemnification</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['termination'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['termination']  / $record->exchange_rate, 2) }}</span>
        </div>
        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['provisionsTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['provisionsTotal']  / $record->exchange_rate, 2) }}</span>
        </div>
    </div>
</div>
