<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $record->title }} Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 15px;
        }
        .details span {
            display: inline-block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">{{ $record->title }} Details</div>

    <div class="details">
        <span><strong>Net Salary:</strong> {{ number_format($record->gross_salary - $record->deductions) }}</span><br>
        <span><strong>Deductions:</strong> {{ number_format($record->deductions) }}</span><br>
        <span><strong>Gross Salary:</strong> {{ number_format($record->gross_salary) }}</span><br>
        <span><strong>Bonus:</strong> {{ number_format($record->bonus) }}</span><br>
        <span><strong>Gross Monthly Salary:</strong> {{ number_format($record->gross_salary + $record->bonus) }}</span><br>
        <span><strong>Payroll Costs:</strong> {{ number_format($record->payroll_costs) }}</span><br>
        <span><strong>Provisions:</strong> {{ number_format($record->provisions) }}</span><br>
        <span><strong>Total Partial:</strong> {{ number_format($record->gross_salary + $record->payroll_costs + $record->provisions + $record->bonus) }}</span><br>
    </div>
</body>
</html>
