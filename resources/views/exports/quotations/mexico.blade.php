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
    $quotationDetails = calculateMexicoQuotation($record, $previousRecords);
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
            <th>Home Office (desk, chair, etc)</th>
            <td align="right">{{ number_format($record->home_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->home_allowance / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Internet Allowance</th>
            <td align="right">{{ number_format($record->internet_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->internet_allowance / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Medical Allowance</th>
            <td align="right">{{ number_format($record->medical_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->medical_allowance / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Car Allowance</th>
            <td align="right">{{ number_format($record->transport_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->transport_allowance / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Food Allowance</th>
            <td align="right">{{ number_format($record->food_allowance, 2) }}</td>
            <td align="right">{{ number_format($record->food_allowance / $record->exchange_rate, 2) }}</td>
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
            <th>Other cost (exempt of Income tax) rows 11, 12 y 13</th>
            <td align="right">{{ number_format($quotationDetails['otherCost'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['otherCost'] / $record->exchange_rate, 2) }}
            </td>
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
            <th>Service taxes - VAT 13%</th>
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
            <th>4.0% Payroll Tax - 2025</th>
            <td align="right"> {{ number_format($quotationDetails['payrollTax'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['payrollTax'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Work Risk</th>
            <td align="right"> {{ number_format($quotationDetails['workRisk'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['workRisk'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Fix Contribution</th>
            <td align="right">{{ number_format($quotationDetails['fixContribution'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['fixContribution'] / $record->exchange_rate, 2) }}
            </td>

        </tr>

        <tr>
            <td></td>
            <th>Cash Benefits</th>
            <td align="right"> {{ number_format($quotationDetails['cashBenefits'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['cashBenefits'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Disability and Life Insurance</th>
            <td align="right"> {{ number_format($quotationDetails['disabilityInsurance'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['disabilityInsurance'] / $record->exchange_rate, 2) }}</td>

        </tr>
        {{-- end --}}

        <tr>
            <td></td>
            <th>Kindergarten</th>
            <td align="right"> {{ number_format($quotationDetails['kindergarten'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['kindergarten'] / $record->exchange_rate, 2) }}</td>

        </tr>

        <tr>
            <td></td>
            <th>Pensions and Beneficiaries</th>
            <td align="right"> {{ number_format($quotationDetails['pensionBeneficiaries'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['pensionBeneficiaries'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Retirement</th>
            <td align="right"> {{ number_format($quotationDetails['retirement'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['retirement'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Old Age Unemployment - 2025</th>
            <td align="right"> {{ number_format($quotationDetails['oldAge'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['oldAge'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>Infonavit</th>
            <td align="right"> {{ number_format($quotationDetails['infonavit'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['infonavit'] / $record->exchange_rate, 2) }}</td>

        </tr>
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
            <th>Vacation Prime - 25%</th>
            <td align="right">{{ number_format($quotationDetails['vacationPrime'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['vacationPrime'] / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">{{ number_format($quotationDetails['vacation'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['vacation'] / $record->exchange_rate, 2) }}</td>
        </tr>

        <tr>
            <td></td>
            <th>Indemnization 90 days</th>
            <td align="right">{{ number_format($quotationDetails['indemnization90'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['indemnization90'] / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>Indemnization 20 days</th>
            <td align="right">{{ number_format($quotationDetails['indemnization20'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['indemnization20'] / $record->exchange_rate, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <th>PTU</th>
            <td align="right"> {{ number_format($quotationDetails['ptu'], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails['ptu'] / $record->exchange_rate, 2) }}</td>

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
        @if ($quotationDetails['hasPreviousRecords'] && $record->hasDifferentCurrency) <tr class="highlight">
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center">Accumulated Provisions</th>
            <td style="background-color: #f29191; font-weight: bold; text-align: center;">
                Cannot generate accumulated provision because the currency has changed. Previous:
                "{{ $previousMonthRecord->currency_name }}", Current: "{{ $record->currency_name }}".
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
            <th>Vacation Prime - 25%</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedVacationPrime'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedVacationPrime'] / $record->exchange_rate, 2) }}
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
        <tr>
            <td></td>
            <th>Indemnization 90 days</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedIndemnization90'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedIndemnization90'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Indemnization 20 days</th>
            <td align="right">{{ number_format($quotationDetails['accumulatedIndemnization20'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedIndemnization20'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>PTU</th>
            <td align="right"> {{ number_format($quotationDetails['accumulatedPtu'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['accumulatedPtu'] / $record->exchange_rate, 2) }}
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
            <th>Vacation Prime - 25%</th>
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
            <th>Indemnization 90 days</th>
            <td align="right">0</td>
            <td align="right">0</td>
        </tr>
        <tr>
            <td></td>
            <th>Indemnization 20 days</th>
            <td align="right">0</td>
            <td align="right">0</td>
        </tr>
        <tr>
            <td></td>
            <th>PTU</th>
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
        'Vacation Prime - 25%',
        'Vacation',
        'Indemnization 90 days',
        'Indemnization 20 days',
        'PTU',
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
            <td align="right">{{ number_format($quotationDetails['balanceSalary13th'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceSalary13th'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Vacation Prime - 25%</th>
            <td align="right">{{ number_format($quotationDetails['balanceVacationPrime'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceVacationPrime'] / $record->exchange_rate, 2) }}
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
            <th>Indemnization 90 days</th>
            <td align="right">{{ number_format($quotationDetails['balanceIndemnization90'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceIndemnization90'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Indemnization 20 days</th>
            <td align="right">{{ number_format($quotationDetails['balanceIndemnization20'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceIndemnization20'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>PTU</th>
            <td align="right">{{ number_format($quotationDetails['balancePtu'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balancePtu'] / $record->exchange_rate, 2) }}
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
