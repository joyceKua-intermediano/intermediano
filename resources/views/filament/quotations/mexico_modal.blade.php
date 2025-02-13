@php
    $quotationDetails = calculateMexicoQuotation($record, []);
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
            <span class="font-medium w-2/5">Total Gross Monthly Salary</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['totalGrossIncome'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5  text-right">USD {{ number_format($quotationDetails['totalGrossIncome'] / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5"> Other cost (exempt of Income tax) rows 11, 12 y 13</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['otherCost'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['otherCost'] / $record->exchange_rate, 2) }}</span>

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

        <div class="flex justify-between p-2 font-bold">
            <span class="font-medium w-2/5">Provisions</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['provisionsTotal'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</span>

        </div>


        <div class="flex justify-between p-2 bg-gray-200">
            <span class="font-medium text-gray-600 w-2/5">Subtotal Gross Salary + Payroll Costs</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['subTotalGrossPayroll'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['subTotalGrossPayroll']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2 font-bold">
            <span class="font-medium w-2/5">Fee</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{  number_format($quotationDetails['fee'] , 2) }}</span>
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
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['bankFee']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2 bg-gray-200">
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
            <span class="font-medium text-gray-600 w-2/5">VAT 16%</span>
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
            <span class="font-medium text-gray-600 	w-2/5">4.0% Payroll Tax - 2025</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['payrollTax'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['payrollTax']  / $record->exchange_rate, 2) }}</span>

        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Work Risk</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['workRisk'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['workRisk']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Fix Contribution</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['fixContribution'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['fixContribution']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Cash Benefits</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['cashBenefits'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['cashBenefits']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Disability and Life Insurance</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['disabilityInsurance'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['disabilityInsurance']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Kindergarten</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['kindergarten'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['kindergarten']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Pensions and Beneficiaries</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['pensionBeneficiaries'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['pensionBeneficiaries']  / $record->exchange_rate, 2) }}</span>
        </div>
        
        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Retirement</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['retirement'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['retirement']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Old Age Unemployment - 2025</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['oldAge'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['oldAge']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Infonavit</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['infonavit'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['infonavit']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Payroll Costs</span>
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
            <span class="font-medium text-gray-600 	w-2/5">13th Salary</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['salary13th'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['salary13th']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Vacation Prime - 25%</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['vacationPrime'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['vacationPrime']  / $record->exchange_rate, 2) }}</span>
        </div>
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
            <span class="font-medium text-gray-600 w-2/5">Indemnization 90 days</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['indemnization90'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['indemnization90']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">Indemnization 20 days</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['indemnization20'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['indemnization20']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between p-2">
            <span class="font-medium text-gray-600 w-2/5">PTU</span>
            <div class="flex justify-between w-40">
                <span class="mr-4">
                    {{ $record->currency_name }}
                </span>
                <span class="text-gray-800">{{ number_format($quotationDetails['ptu'], 2) }}</span>
            </div>
            <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['ptu']  / $record->exchange_rate, 2) }}</span>
        </div>

        <div class="flex justify-between bg-gray-200 p-2 font-bold">
            <span class="font-medium w-2/5">Total Provisions</span>
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
