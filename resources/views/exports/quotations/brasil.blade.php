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
    $quotationDetails = calculateBrasilQuotation($record, $previousRecords);
    @endphp

    <table style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: red">
        <tr>
            <td></td>
            <th rowspan="2" style="background-color: #7d2a1d; padding: 20px; text-align:center" align="center" width="70">
                <img src="{{ public_path('images/logo.jpg') }}" height="80" style="padding: 40px; text-align:center" alt="Company Logo">
            </th>
            <td colspan="2" valign="middle" align="center" width="40" style="background-color: #7d2a1d; color:white; font-weight:bold">{{ $record->country->name }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" valign="middle" align="center" width="40" style="background-color: #7d2a1d; color:white; font-weight:bold">{{ $record->title }}</td>
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
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Gross Salary + Payroll Cost and Provisions</th>
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
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Partial</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Services taxes</th>
            <td align="right">{{ number_format($quotationDetails['servicesTaxes'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['servicesTaxes'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Gross Payroll, PR Costs, Fees and Taxes</th>
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
        {{-- start --}}
        <tr>
            <td></td>
            <th>INSS</th>
            <td align="right"> {{ number_format($quotationDetails['inss'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['inss'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>FGTS</th>
            <td align="right"> {{ number_format($quotationDetails['fgts'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['fgts'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>FGTS Fine</th>
            <td align="right">{{ number_format($quotationDetails['fgtsFine'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['fgtsFine'] / $record->exchange_rate, 2) }}
            </td>

        </tr>

        <tr>
            <td></td>
            <th>FGTS and INSS over Vacation and 13th Salary</th>
            <td align="right"> {{ number_format($quotationDetails['fgtsInss'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['fgtsInss'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Medical Plan and Life Insurance</th>
            <td align="right"> {{ number_format($quotationDetails['medicalInsurance'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['medicalInsurance'] / $record->exchange_rate, 2) }}</td>

        </tr>
        {{-- end --}}

        <tr>
            <td></td>
            <th>Meal Tickets</th>
            <td align="right"> {{ number_format($quotationDetails['mealTicket'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['mealTicket'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Transportation Tickets</th>
            <td align="right"> {{ number_format($quotationDetails['transportationTicket'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['transportationTicket'] / $record->exchange_rate, 2) }}</td>

        </tr>
        @if($record->cluster_name === 'PartnerCanada' || $record->cluster_name === 'IntermedianoCanada')
        <tr>
            <td></td>
            <th>Operational Costs</th>
            <td align="right"> {{ number_format($quotationDetails['operationalCosts'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['operationalCosts'] / $record->exchange_rate, 2) }}</td>
        </tr>
        @endif

        <td></td>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Payroll Costs</th>
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
            <th>13th Salary</th>
            <td align="right">{{ number_format($quotationDetails['salary13th'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['salary13th'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">{{ number_format($quotationDetails['vacation'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['vacation'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>1/3 Vacation Bonus</th>
            <td align="right">{{ number_format($quotationDetails['vacationBonus'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['vacationBonus'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Termination</th>
            <td align="right"> {{ number_format($quotationDetails['termination'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['termination'] / $record->exchange_rate, 2) }}</td>

        </tr>


        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Provisions</th>
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
        @if ($quotationDetails['hasPreviousRecords'] && $record->hasDifferentCurrency)
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center">Accumulated Provisions</th>
            <td style="background-color: #f29191; font-weight: bold; text-align: center;">
                Cannot generate accumulated provision because the currency has changed.
                Previous currencies: "{{ $record->uniqueCurrencies->join(', ') }}", Current: "{{ $record->currency_name }}".
            </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>
        @elseif ($quotationDetails['hasPreviousRecords'])
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
            <th>13th Salary</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedSalary13th'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedSalary13th'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedVacation'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedVacation'] / $record->exchange_rate, 2) }}
            </td>

        </tr>

        <tr>
            <td></td>
            <th>1/3 Vacation Bonus</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedVacationBonus'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedVacationBonus'] / $record->exchange_rate, 2) }}
            </td>

        </tr>
        <tr>
            <td></td>
            <th>Termination</th>
            <td align="right"> {{ number_format($quotationDetails['accumulatedTermination'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedTermination'] / $record->exchange_rate, 2) }}
            </td>

        </tr>

        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['accumulatedProvisionsTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
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
            <th>13th Salary</th>
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
            <th>1/3 Vacation Bonus</th>
            <td align="right">0</td>
            <td align="right">0</td>
        </tr>
        <tr>
            <td></td>
            <th>Termination</th>
            <td align="right">0</td>
            <td align="right">0</td>
        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                0</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                0
            </td>

        </tr>
        @endif
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>
        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>

        </tr>

        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center"> Payment Provisions</th>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">
                {{ $record->currency_name }}
            </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>


        @php
        $customOrder = [
        '13th Salary',
        'Vacation',
        '1/3 Vacation Bonus',
        'Termination',
        ];

        $provisionsByName = $record->paymentProvisions->mapWithKeys(function ($item) {
        return [trim($item->provisionType->name) => $item->amount];
        });
        @endphp

        @foreach ($customOrder as $provisionName)
        @php
        $amount = $provisionsByName[$provisionName] ?? 0;
        @endphp
        <tr>
            <td></td>
            <th>{{ $provisionName }}</th>
            <td align="right">{{ number_format($amount, 2) }}</td>
            <td align="right">
                {{ number_format($amount / $record->exchange_rate, 2) }}
            </td>
        </tr>
        @endforeach
        @php
        $totalAmount = $record->paymentProvisions->sum('amount');
        $totalConverted = $totalAmount / $record->exchange_rate;
        @endphp
        {{-- <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th>Total</th>
            <td align="right">{{ number_format($totalAmount, 2) }}</td>
        <td align="right">{{ number_format($totalConverted, 2) }}</td>
        </tr> --}}

        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>
        </tr>
        <tr>
            <td></td>
            <th colspan="3" style="border: 2px solid rgb(255, 255, 255);"></th>

        </tr>
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center">Balance Provisions</th>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">
                {{ $record->currency_name }}
            </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>

        <tr>
            <td></td>
            <th>13th Salary</th>
            <td align="right">{{ number_format($quotationDetails['balance13th'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balance13th'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Vacation</th>
            <td align="right">{{ number_format($quotationDetails['balanceVacation'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceVacation'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>1/3 Vacation Bonus</th>
            <td align="right">{{ number_format($quotationDetails['balanceVacationBonus'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceVacationBonus'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Termination</th>
            <td align="right">{{ number_format($quotationDetails['balanceTermination'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceTermination'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['balanceProvisionsTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['balanceProvisionsTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>
    </table>

</body>

</html>
