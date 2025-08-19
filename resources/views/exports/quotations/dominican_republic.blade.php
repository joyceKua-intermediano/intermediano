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
    use Illuminate\Support\Str;
    $quotationDetails = calculateDominicanRepublicQuotation($record, $previousRecords);
    $isPartner = Str::contains($record->cluster_name, 'Partner');
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
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total Partial</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['subTotal'] / $record->exchange_rate, 2) }}</td>

        </tr>
        <tr>
            <td></td>
            <th>VAT 15%</th>
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

        @foreach ($quotationDetails['payrollCostsLists'] as $payrollCostsItem)
        <tr>
            <td></td>
            <th>{{ strtoupper($payrollCostsItem) }}</th>
            <td align="right"> {{ number_format($quotationDetails[$payrollCostsItem], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails[$payrollCostsItem] / $record->exchange_rate, 2) }}</td>
        </tr>
        @endforeach

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

        @foreach ($quotationDetails['provisionLists'] as $provisionItem)
        <tr>
            <td></td>
            <th>{{ camelCaseToWords($provisionItem) }}</th>
            <td align="right">{{ number_format($quotationDetails[$provisionItem], 2) }}</td>
            <td align="right">{{ number_format($quotationDetails[$provisionItem] / $record->exchange_rate, 2) }}</td>
        </tr>

        @endforeach


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
        @elseif ($quotationDetails['hasPreviousRecords'] && !$isPartner)
        <!-- Accumulated Provisions -->
        <tr class="highlight">
            <td></td>
            <th style="background-color: #a8a8a8; font-weight:bold" align="center"> Accumulated Provisions</th>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">
                {{ $record->currency_name }}
            </td>
            <td style="background-color: #a8a8a8; font-weight:bold" align="center">USD</td>
        </tr>

        @foreach ($quotationDetails['accumulatedLists'] as $accumulatedItem)
        @php
        $labelMap = [
        'accumulatedSalary13th' => '13th Salary',
        'accumulatedAnnualBonus' => 'Annual Bonus',
        'accumulateNotice' => 'Notice period',
        'accumulateUnemployement' => 'Unemployment',
        'accumulatedVacations' => 'Vacation',
        ];
        $label = $labelMap[$accumulatedItem] ?? $accumulatedItem;
        @endphp
        <tr>
            <td></td>
            <th>{{ $label }}</th>
            <td align="right">{{ number_format($quotationDetails[$accumulatedItem], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails[$accumulatedItem] / $record->exchange_rate, 2) }}
            </td>

        </tr>
        @endforeach
        <tr style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
            <td></td>
            <th style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">Total</th>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['accumulatedProvisionsTotal'], 2) }}</td>
            <td align="right" style="border: 2px solid rgb(0, 0, 0); font-weight: bold; background-color: #a8a8a8">
                {{ number_format($quotationDetails['accumulatedProvisionsTotal'] / $record->exchange_rate, 2) }}
            </td>

        </tr>
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
        'Annual Bonus',
        'Notice period',
        'Unemployment',
        'Vacation'
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
            <th>Annual Bonus</th>
            <td align="right">{{ number_format($quotationDetails['balanceAnnualBonus'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceAnnualBonus'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Notice</th>
            <td align="right">{{ number_format($quotationDetails['balanceNotice'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceNotice'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Unemployment</th>
            <td align="right">{{ number_format($quotationDetails['balanceUnemployment'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceUnemployment'] / $record->exchange_rate, 2) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">{{ number_format($quotationDetails['balanceVacations'], 2) }}</td>
            <td align="right">
                {{ number_format($quotationDetails['balanceVacations'] / $record->exchange_rate, 2) }}
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
        @elseif(!$isQuotation && !$isPartner)
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
            <th>Compensation</th>
            <td align="right">0</td>
            <td align="right">0</td>

        </tr>
        <tr>
            <td></td>
            <th>Vacations</th>
            <td align="right">0</td>
            <td align="right">0</td>
        </tr>
        <tr>
            <td></td>
            <th>Christmas Bonus</th>
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
    </table>
</body>

</html>
