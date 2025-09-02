@php
$quotationDetails = calculateBrasilQuotation($record, []);
$intermedianoCompany =preg_replace('/(?<!^)([A-Z]) /', ' $1' , $record->cluster_name);
    @endphp

    <div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold text-gray-800"> {{ str_replace('/', '.', $record->title) }} quotation for
            {{ $intermedianoCompany }} - {{ $record->is_payroll ? $record->consultant->name : '' }} (Ordinary) </h3>
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
                <span class="font-medium text-gray-600 w-2/5">Gross Salary + Payroll Cost & Provisions</span>
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
                    <span class="text-gray-800">{{ number_format($quotationDetails['fee'] , 2) }}</span>
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
                <span class="font-medium text-gray-600 w-2/5">Total Partial</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['subTotal'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['subTotal']  / $record->exchange_rate, 2) }}</span>

            </div>
            @if($quotationDetails['isPartner'])
            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">IRPJ</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['irpj'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['irpj']  / $record->exchange_rate, 2) }}</span>
            </div>
            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">ISS</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['iss'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['iss']  / $record->exchange_rate, 2) }}</span>
            </div>

            @else
            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Services taxes</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['servicesTaxes'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['servicesTaxes']  / $record->exchange_rate, 2) }}</span>
            </div>
            @endif

            <div class="flex justify-between bg-gray-200 p-2 font-bold">
                <span class="font-medium w-2/5">Gross Payroll, PR Costs, Fees & Taxes</span>
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
                <span class="font-medium text-gray-600 	w-2/5">INSS</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['inss'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['inss']  / $record->exchange_rate, 2) }}</span>

            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">FGTS</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['fgts'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['fgts']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">FGTS Fine</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['fgtsFine'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['fgtsFine']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">FGTS & INSS over Vacation and 13th Salary</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['fgtsInss'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['fgtsInss']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Medical Plan & Life Insurance</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['medicalInsurance'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['medicalInsurance']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Meal Tickets</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['mealTicket'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['mealTicket']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Transportation Tickets</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['transportationTicket'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['transportationTicket']  / $record->exchange_rate, 2) }}</span>
            </div>
            @if($quotationDetails['operationalCosts'] != 0)
            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Operational Costs</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['operationalCosts'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['operationalCosts']  / $record->exchange_rate, 2) }}</span>
            </div>
            @endif

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
                <span class="font-medium text-gray-600 w-2/5">1/3 Vacation Bonus</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['vacationBonus'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['vacationBonus']  / $record->exchange_rate, 2) }}</span>
            </div>

            <div class="flex justify-between p-2">
                <span class="font-medium text-gray-600 w-2/5">Termination</span>
                <div class="flex justify-between w-40">
                    <span class="mr-4">
                        {{ $record->currency_name }}
                    </span>
                    <span class="text-gray-800">{{ number_format($quotationDetails['termination'], 2) }}</span>
                </div>
                <span class="text-gray-800 w-1/5 text-right">USD {{ number_format($quotationDetails['termination']  / $record->exchange_rate, 2) }}</span>
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
