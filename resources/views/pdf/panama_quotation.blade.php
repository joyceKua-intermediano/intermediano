<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $record->title }} Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
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
    $quotationDetails = calculatePanamaQuotation($record, []);
    @endphp

    <table class="table">
        <tr class="headerTable">
            <th rowspan="2"> <img src="{{ public_path('images/logo.jpg') }}" alt="logo" style="width: 100px; height: auto;">
            </th>

            <td class="p-4 textWhite textWeightBold" colspan="1">{{ $record->country->name }}</td>
        </tr>
        <tr>
            <td class="headerTable textWhite textWeightBold" colspan="1">{{ $record->title }}</td>
        </tr>
        <tr style="{{ $record->home_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Home Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->home_allowance, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->transport_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Transport Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->transport_allowance, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->medical_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Medical Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->medical_allowance, 2) }}</span>
            </td>
        </tr>
        <tr style="{{ $record->internet_allowance == 0 ? 'display: none' : '' }}">
            <th class="p-4">Internet Allowance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->internet_allowance, 2) }}</span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Gross Salary</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($quotationDetails['grossSalary'], 2) }}</span>
            </td>
        </tr>

        <tr style="{{ $record->bonus == 0 ? 'display: none' : '' }}">
            <th class="p-4">Bonus</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">{{ number_format($record->bonus, 2) }}</span>
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
        </tr>
        <tr>
            <th class="p-4">Payroll Costs</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}
                </span>
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
        </tr>

        <tr>
            <th class="p-4 text-left">Subtotal Gross Salary + Payroll Costs</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['subTotalGrossPayroll'], 2) }}
                </span>
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
        </tr>
        <tr class="">
            <th class="p-4 text-left">Subtotal</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['subTotal'], 2) }}
                </span>
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
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Total Partial</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['totalPartial'], 2) }}
                </span>
            </td>
        </tr>
        <tr>
            <th class="p-4 ">ITBMS 7%</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['servicesTaxes'], 2) }}
                </span>
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
        </tr>


        {{-- payroll --}}
        <tr class="">
            <th class="p-4 textWeightBold"></th>
            <th class="p-4 text-left"></th>
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Payroll Costs</th>
            <th class="p-4 text-left">USD</th>
        </tr>
        <tr class="">
            <th class="p-4 text-left">CSS</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['css'], 2) }}
                </span>
            </td>
        </tr>
        <tr>
            <th class="p-4 text-left">Professional Risk</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['professionalRisk'], 2) }}
                </span>
            </td>
        </tr>
        <tr>
            <th class="p-4 text-left">Educational Insurance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['educationalInsurance'], 2) }}
                </span>
            </td>
        </tr>

        <tr class="highlight">
            <th class="p-4 textWeightBold">Total</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}
                </span>
            </td>
        </tr>

        {{-- Provisions --}}
        <tr class="">
            <th class=""></th>
            <td class=""></td>
        </tr>
        <tr class="highlight">
            <th class="p-4 textWeightBold">Provisions</th>
            <td class="p-4">USD</td>
        </tr>
        <tr class="">
            <th class="p-4">Christmas bonus</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['christmasBonus'], 2) }}
                </span>
            </td>
        </tr>
        <tr class="">
            <th class="p-4">Vacations</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['vacations'], 2) }}
                </span>
            </td>
        </tr>

        <tr class="">
            <th class="p-4">Forewarning</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['forewarning'], 2) }}
                </span>
            </td>
        </tr>

        <tr class="">
            <th class="p-4">Severance</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['severance'], 2) }}
                </span>
            </td>
        </tr>

        <tr class="">
            <th class="p-4">Seniority</th>
            <td class="p-4 space-between">
                <span class="currencyAlignment"> {{ $record->currency_name }}</span>
                <span class="recordAlignment">
                    {{ number_format($quotationDetails['seniority'], 2) }}
                </span>
            </td>
        </tr>

        <tr class="highlight">
            <th class="p-4 textWeightBold">Total</th>
            <td class="p-4" style="text-align: center">
                <span> {{ $record->currency_name }}</span>
                <span>
                    {{ number_format($quotationDetails['provisionsTotal'], 2) }}

                </span>
            </td>
        </tr>

    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('F j, Y') }}</p>
    </div>
</body>

</html>
