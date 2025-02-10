<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>{{ $record->title }} Details</title> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .table {
            width: 100%;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #7d2a1d;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .highlight {
            background-color: #ccc;
            font-weight: bold;
            color: red
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>

<body>
    @php
        $quotationDetails = calculateCostaRicaQuotation($record, $previousMonthRecord);
    @endphp

    <table style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: red">
        <tr>
            <td></td>
            <th rowspan="2" style="background-color: #7d2a1d; padding: 20px; text-align:center" align="center"
                width="70">
                <img src="{{ public_path('images/logo.jpg') }}" height="80" style="padding: 40px; text-align:center"
                    alt="Company Logo">
            </th>
            <td colspan="2" valign="middle" align="center" width="40"
                style="background-color: #7d2a1d; color:white; font-weight:bold">{{ $record->country->name }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" valign="middle" align="center" width="40"
                style="background-color: #7d2a1d; color:white; font-weight:bold">{{ $record->title }}</td>
        </tr>

        <tr>
            <td></td>
            <td style="background-color: #a8a8a8;"></td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">{{ $record->currency_name }} </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>


        <tr>
            <td></td>
            <th>Home Allowance</th>
            <td align="right">{{ number_format($record->home_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->home_allowance / $record->exchange_rate, 2) }}</td>
        </tr>

        <tr>
            <td></td>
            <th>Medical Allowance</th>
            <td align="right">{{ number_format($record->medical_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->medical_allowance / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Transport Allowance</th>
            <td align="right">{{ number_format($record->transport_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->transport_allowance / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Internet Allowance</th>
            <td align="right">{{ number_format($record->internet_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->internet_allowance / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Gross Salary</th>
            <td align="right">{{ number_format($quotationDetails['grossSalary'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['grossSalary'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Bonus</th>
            <td align="right">{{ number_format($record->bonus, 2) }}</td>
            <td align="right">{{ number_format($record->bonus / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr class="highlight" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8 ">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Gross Income
            </th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['totalGrossIncome'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['totalGrossIncome'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Payroll Costs</th>
            <td align="right">{{ number_format($quotationDetails['payrollCostsTotal'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr class="highlight">
            <td></td>
            <th>Provisions</th>
            <td align="right">{{ number_format($quotationDetails['provisionsTotal'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}
            </td>

        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8 ">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Subtotal Gross
                Salary + Payroll Costs</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotalGrossPayroll'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotalGrossPayroll'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr class="highlight">
            <td></td>
            <th>Fee</th>
            <td align="right">{{ number_format($quotationDetails['fee'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['fee'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Bank Fee</th>
            <td align="right">{{ number_format($quotationDetails['bankFee'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['bankFee'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8 ">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Subtotal</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr class="highlight">
            <td></td>
            <th>Municipal tax - ICA 1%</th>
            <td align="right">{{ number_format($quotationDetails['municipalTax'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['municipalTax'] / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Service taxes - VAT 19%</th>
            <td align="right">{{ number_format($quotationDetails['servicesTaxes'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['servicesTaxes'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Invoice</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['totalInvoice'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['totalInvoice'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>
        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>
        </tr>
        <!-- Payroll Costs -->
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center">Payroll Costs</th>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">{{ $record->currency_name }} </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>
        <tr>
            <td></td>
            <th>Employer taxes</th>
            <td align="right"> {{ number_format($quotationDetails['employerTaxes'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['employerTaxes'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>INS Policy</th>
            <td align="right"> {{ number_format($quotationDetails['insPolicy'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['insPolicy'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Medical Insurance</th>
            <td align="right">{{ number_format($quotationDetails['medicalInsurance'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['medicalInsurance'] / $record->exchange_rate, 2) }}
            </td>

        </tr>
        <td></td>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['payrollCostsTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['payrollCostsTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>

        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>

        </tr>
        <!-- Provisions -->
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center">Provisions</th>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">{{ $record->currency_name }} </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>

        <tr>
            <td></td>
            <th>Unemployment</th>
            <td align="right">{{ number_format($quotationDetails['unEmployment'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['unEmployment'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Forewarning</th>
            <td align="right">{{ number_format($quotationDetails['forewarning'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['forewarning'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Bonus</th>
            <td align="right"> {{ number_format($quotationDetails['bonus'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['bonus'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">{{ number_format($quotationDetails['vacation'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['vacation'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['provisionsTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['provisionsTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>
        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>

        </tr>
        @if ($quotationDetails['previousMonthGrossIncome'] && $previousMonthRecord->currency_name !== $record->currency_name)
            <tr class="highlight">
                <td></td>
                <th style="background-color: #a8a8a8; font-weight:bold" align="center">Accumulated Provisions</th>
                <td style="background-color: #f29191; font-weight: bold; text-align: center;">
                    Cannot generate accumulated provision because the currency has changed. Previous:
                    "{{ $previousMonthRecord->currency_name }}", Current: "{{ $record->currency_name }}".
                </td>

                <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
            </tr>
        @elseif ($quotationDetails['previousMonthGrossIncome'])
            <!-- Accumulated Provisions -->
            <tr class="highlight">
                <td></td>
                <th style="background-color: #a8a8a8; font-weight:bold" align="center"> Accumulated Provisions</th>
                <td style="background-color: #a8a8a8; font-weight:bold" align="center">
                    {{ $record->currency_name }}
                </td>
                <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
            </tr>

            <tr>
                <td></td>
                <th>Unemployment</th>
                <td align="right">{{ number_format($quotationDetails['accumulatedUnEmployment'], 2) }}</td>
                <td align="right">
                    {{ number_format($quotationDetails['accumulatedUnEmployment'] / $record->exchange_rate, 2) }}</td>

            </tr>
            <tr>
                <td></td>
                <th>Forewarning</th>
                <td align="right">{{ number_format($quotationDetails['accumulatedForewarning'], 2) }}</td>
                <td align="right">
                    {{ number_format($quotationDetails['accumulatedForewarning'] / $record->exchange_rate, 2) }}
                </td>

            </tr>
            <tr>
                <td></td>
                <th>Bonus</th>
                <td align="right"> {{ number_format($quotationDetails['accumulatedBonus'], 2) }}</td>
                <td align="right">
                    {{ number_format($quotationDetails['accumulatedBonus'] / $record->exchange_rate, 2) }}
                </td>

            </tr>
            <tr>
                <td></td>
                <th>Vacations</th>
                <td align="right">{{ number_format($quotationDetails['accumulatedVacation'], 2) }}</td>
                <td align="right">
                    {{ number_format($quotationDetails['accumulatedVacation'] / $record->exchange_rate, 2) }}
                </td>

            </tr>
            <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                <td></td>
                <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
                <td align="right"
                    style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                    {{ number_format($quotationDetails['accumulatedProvisionsTotal'], 2) }}</td>
                <td align="right"
                    style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                    {{ number_format($quotationDetails['accumulatedProvisionsTotal'] / $record->exchange_rate, 2) }}
                </td>

            </tr>
        @elseif(!$isQuotation)
            <tr class="highlight">
                <td></td>
                <th style="background-color: #a8a8a8; font-weight:bold" align="center"> Accumulated Provisions</th>
                <td style="background-color: #a8a8a8; font-weight:bold" align="center">
                    {{ $record->currency_name }}
                </td>
                <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
            </tr>

            <tr>
                <td></td>
                <th>Cesantias</th>
                <td align="right">0</td>
                <td align="right">0</td>

            </tr>
            <tr>
                <td></td>
                <th>Intereses de Cesantias</th>
                <td align="right">0</td>
                <td align="right">0</td>
            </tr>
            <tr>
                <td></td>
                <th>Prima</th>
                <td align="right">0</td>
                <td align="right">0</td>
            </tr>
            <tr>
                <td></td>
                <th>Vacation</th>
                <td align="right">0</td>
                <td align="right">0</td>
            </tr>
            <tr>
                <td></td>
                <th>Indemnization</th>
                <td align="right">0</td>
                <td align="right">0</td>
            </tr>

            <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                <td></td>
                <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
                <td align="right"
                    style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                    0</td>
                <td align="right"
                    style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                    0
                </td>

            </tr>
        @endif


    </table>

</body>

</html>
