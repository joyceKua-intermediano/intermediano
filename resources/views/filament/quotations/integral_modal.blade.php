@php
    $quotationDetails = calculateIntegralQuotation($record, []);
    $intermedianoCompany =preg_replace('/(?<!^)([A-Z])/', ' $1', $record->cluster_name);
@endphp

<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800"> {{ str_replace('/', '.', $record->title) }} quotation for
        {{ $intermedianoCompany }}  - {{ $record->is_payroll ? $record->consultant->name : '' }} (Integral)</h3>
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
                <span class="text-gray-800">{{ number_format($quotationDetails['bankFee'] , 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['bankFee'] / $record->exchange_rate, 2) }}</span>
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

        <div class="flex justify-between bg-gray-200 p-2">
            <span class="font-medium w-2/5">Municipal tax - ICA 1%</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['municipalTax'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['municipalTax']  / $record->exchange_rate, 2) }}</span>

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
            <span class="font-medium text-gray-600 	w-2/5">Pension Fund</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['pensionFund'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['pensionFund']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Health Fund</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['healthFund'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['healthFund']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">ICBF Contribution</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['icbfContribution'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['icbfContribution']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Sena Contribution</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['senaContribution'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['senaContribution']  / $record->exchange_rate, 2) }}</span>
        </div>


        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">ARL Contribution</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['arlContribution'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['arlContribution']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Compensation Fund Contribution</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['compensationFundContribution'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['compensationFundContribution']  / $record->exchange_rate, 2) }}</span>

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
            <span class="font-medium text-gray-600 w-2/5">Vacation</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['vacation'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['vacation']  / $record->exchange_rate, 2) }}</span>
        </div>


        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Indemnization</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['indemnization'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['indemnization']  / $record->exchange_rate, 2) }}</span>
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
