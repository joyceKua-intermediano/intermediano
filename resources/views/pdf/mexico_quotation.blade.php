<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $record->title }} Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            @if(empty($hideHeader)) margin: 20px;
            @endif
        }

        .headerTable {
            background-color: #7d2a1d
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;

        }

        .table th,
        .table td {
            padding: 10px 15px;
            text-align: left;
            border: 1px solid #ddd;
            @if(empty($hideHeader)) font-size: inherit;
            @else font-size: 12px;
            padding: 6px 10px;
            @endif
        }

        .table th {
            font-weight: normal;
            text-transform: none
        }

        .highlight {
            background-color: #ccc;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
            color: #555;
        }

        .textWhite {
            color: white
        }

        .textWeightBold {
            font-weight: 800 !important
        }

        td.space-between {
            position: relative;

        }

        .currencyAlignment {
            position: absolute;
            left: 0;
            padding-left: 10px
        }

        .recordAlignment {
            padding-right: 10px;
            position: absolute;
            right: 0;
        }

    </style>
</head>

<body>
    @php
    $quotationDetails = calculateMexicoQuotation($record, []);
    @endphp

    <table class="table">
        @if(empty($hideHeader))

        <tr class="headerTable">
            <th rowspan="2"> <img src="{{ public_path('images/logo.jpg') }}" alt="logo" style="width: 100px; height: auto;">
            </th>

            <td class="p-4 textWhite textWeightBold" colspan="2">{{ $record->country->name }}</td>
        </tr>
        <tr>
            <td class="headerTable textWhite textWeightBold" colspan="2">{{ $record->title }}</td>
        </tr>
        @endif

        <tr style="{{ $record->home_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Home Office (desk, chair, etc)</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->home_allowance, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->home_allowance / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->internet_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Internet Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->internet_allowance, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->internet_allowance / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->medical_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Medical Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->medical_allowance, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->medical_allowance / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->transport_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Car Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->transport_allowance, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->transport_allowance / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->transport_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Food Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->food_allowance, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->food_allowance / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Gross Salary</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['grossSalary'], 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['grossSalary'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        <tr style="{{ $record->bonus == 0 ? 'display: none' : '' }}">
            <th class="p-4">Bonus</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->bonus, 2) }}</span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($record->bonus / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        <tr class="highlight">
            <th class="p-4 textWeightBold">Total Gross Income</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['totalGrossIncome'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['totalGrossIncome'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr>
            <th class="p-4">Other cost (exempt of Income tax) rows 11, 12 y 13</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['otherCost'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['otherCost'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr>
            <th class="p-4">Payroll Costs</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        <tr class="highlight">
            <th class="p-4 textWeightBold">Provisions</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['provisionsTotal'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        <tr>
            <th class="p-4 text-left">Subtotal Gross Salary + Payroll Costs</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['subTotalGrossPayroll'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['subTotalGrossPayroll'] / $record->exchange_rate, 2) }}</span>
            </td>

        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Fee</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['fee'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['fee'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr>
            <th class="p-4 ">Bank Fee</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['bankFee'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['bankFee'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Subtotal</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['subTotal'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['subTotal'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr>
            <th class="p-4">VAT 16%</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['servicesTaxes'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['servicesTaxes'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="highlight">
            <th class="p-4 text-left textWeightBold">Total Invoice</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['totalInvoice'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['totalInvoice'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>


        {{-- payroll --}}
        <tr style="border: 2px solid white !important;">
            <td colspan="3" style="padding-top: 60px;"></td>
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Payroll Costs</th>
            <th class="p-4 text-left">BRL</th>
            <td class="p-4">USD</td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">3.0% Payroll Tax - 2025</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['payrollTax'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['payrollTax'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Work Risk</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['workRisk'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['workRisk'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Fix Contribution</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['fixContribution'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['fixContribution'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Cash Benefits</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['cashBenefits'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['cashBenefits'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Disability and Life Insurance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['disabilityInsurance'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['disabilityInsurance'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Kindergarten</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['kindergarten'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['kindergarten'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Pensions and Beneficiaries</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['pensionBeneficiaries'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['pensionBeneficiaries'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Retirement</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['retirement'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['retirement'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Old Age Unemployment - 2025</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['oldAge'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['oldAge'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4 text-left">Infonavit</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['infonavit'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['infonavit'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Total Payroll Costs</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        {{-- Provisions --}}
        <tr style="border: 2px solid white !important;">
            <td colspan="3" style="padding-top: 20px;"></td>
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Provisions</th>
            <td class="p-4">BRL</td>
            <td class="p-4">USD</td>
        </tr>
        <tr class="">
            <th class="p-4">13th Salary</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['salary13th'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['salary13th'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Vacation Prime - 25%</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['vacationPrime'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['vacationPrime'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Vacations</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['vacation'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['vacation'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Indemnization 90 days</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['indemnization90'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['indemnization90'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Indemnization 20 days</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['indemnization20'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['indemnization20'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">PTU</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['ptu'], 2) }}
                </span>
            </td>
            <td class="p-4 space-between">
                <span class="currencyAlignment">USD</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['ptu'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

        <tr class="highlight">
            <th class="p-4 textWeightBold">Total Provisions</th>
            <td class="p-4" style="text-align: center">
                <span> {{ $record->currency_name }}</span>
                <span>
                    {{ number_format($quotationDetails['provisionsTotal'], 2) }}

                </span>
            </td>

            <td class="p-4" style="text-align: center">
                <span>USD</span>
                <span>{{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</span>
            </td>
        </tr>

    </table>

    @if(empty($hideHeader))
    <div class="footer">
        <p>Generated on {{ now()->format('F j, Y') }}</p>
    </div>
    @endif
</body>

</html>
