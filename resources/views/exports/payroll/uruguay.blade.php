<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table tr:nth-child(odd) {
            background-color: #f2f2f2; 
        }
        table tr:nth-child(even) {
            background-color: #ffffff; 
        }
        table th, table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd; 
        }
        table th {
            background-color: #7d2a1d; 
            color: white; 
        }
    </style>
</head>
<body>
    @foreach ($record->companies as $company)
        @php
            $totalGrossMonthly = 0;
            $totalOvertime = 0;
            $totalOther = 0;
            $totalOtherExpenses = 0;
            $totalBankingFee = 0;
            $totalFee = 0;
            $totalInvoice = 0;
            $totalAllInvoice = 0;
            $itemCounter = 1;
            $countItems = 0;

            foreach ($data as $item) {
                if (($company->name == 'Wesco Anixter USVI, LLC' && $item['country_name'] == 'USVI') || ($company->name == 'WESCO DISTRIBUTION INC.' && $item['country_name'] != 'USVI')) {
                    $countItems++;
                    $totalGrossMonthly += $item['monthly_salary'];
                    $totalOvertime += $item['overtime'];
                    $totalOther += $item['other'];
                    $totalOtherExpenses += $item['other_expenses'];
                }
            }
            $intermedianoFee = (($record->fee / 100) * ($totalGrossMonthly + $totalOvertime + $totalOther)) / $countItems;
            $totalIntermedianoFee = $intermedianoFee * $countItems;
            $totalBankingFee = $countItems * $record->bank_fee;
        @endphp

        <table>
            <thead>
                <tr>
                    <td></td>
                    <th style="background-color: #7d2a1d;" align="center">
                        <img src="{{ public_path('images/logo.jpg') }}" valign="middle" height="70" alt="Company Logo">
                    </th>
                    <td colspan="9" valign="middle" align="left" style="background-color: #7d2a1d; color:white; font-weight:bold">{{ $company->name }}</td>
                </tr>
                <tr height="50">
                    <td></td>
                    <th style="font-weight:bold" valign="middle" align="left">Item</th>
                    <th style="font-weight:bold" valign="middle" align="left">Country</th>
                    <th style="font-weight:bold" valign="middle" align="left">Name</th>
                    <th style="font-weight:bold" valign="middle" align="left">Gross Monthly Payment (USD)</th>
                    <th style="font-weight:bold" valign="middle" align="left">Overtime</th>
                    <th style="font-weight:bold" valign="middle" align="left">Other</th>
                    <th style="font-weight:bold" valign="middle" align="left">Other Expenses (Banking fee Reimbursement)</th>
                    <th style="font-weight:bold" valign="middle" align="left">Banking Fee (USD)</th>
                    <th style="font-weight:bold" valign="middle" align="left">Intermediano Fee (USD)</th>
                    <th style="font-weight:bold" valign="middle" align="left">Total Invoice (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    @if (($company->name == 'Wesco Anixter USVI, LLC' && $item['country_name'] == 'USVI') || ($company->name == 'WESCO DISTRIBUTION INC.' && $item['country_name'] != 'USVI'))
                        @php
                            $totalInvoice = $item['monthly_salary'] + $item['overtime'] + $item['other'] + $item['other_expenses'] + $record->bank_fee + $intermedianoFee;
                            $totalAllInvoice += $totalInvoice;
                            $rowColor = ($itemCounter % 2 == 0) ? '#ffffff' : '#dedede';
                        @endphp
                        <tr>
                            <td></td>
                            <td style="background-color: {{ $rowColor }}">{{ $itemCounter }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['country_name'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['consultant_name'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['monthly_salary'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['overtime'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['other'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $item['other_expenses'] }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ $record->bank_fee }}</td>
                            <td style="background-color: {{ $rowColor }}">{{ number_format($intermedianoFee, 2) }}</td>
                            <td style="background-color: {{ $rowColor }}" align="right">{{ number_format($totalInvoice, 2) }}</td>
                        </tr>
                        @php
                        $itemCounter++;
                    @endphp
                    @endif
                @endforeach
                <tr >
                    <td></td>
                    <td style="font-weight:bold" align="right">{{ $itemCounter - 1 }}</td> 
                    <td></td>
                    <td></td>
                    <td style="font-weight:bold" align="right">{{ $totalGrossMonthly }}</td>
                    <td style="font-weight:bold" align="right">{{ $totalOvertime }}</td>
                    <td style="font-weight:bold" align="right">{{ $totalOther }}</td>
                    <td style="font-weight:bold" align="right">{{ $totalOtherExpenses }}</td>
                    <td style="font-weight:bold" align="right">{{ $totalBankingFee }}</td>
                    <td style="font-weight:bold" align="right">{{ number_format($totalIntermedianoFee, 2) }}</td>
                    <td style="font-weight:bold" align="right">{{ number_format($totalAllInvoice, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <br><br>
    @endforeach
</body>
</html>