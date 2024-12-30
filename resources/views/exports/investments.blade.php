<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Country</th>
            <th>Bank</th>
            <th>Currency</th>
            <th>Capital</th>
            <th>Interest Rate</th>
            <th>Monthly Interest</th>
            <th>Total Interest</th>
            <th>Total Amount</th>
            <th>Net Amount</th>
            <th>Deposit Date</th>
            <th>Withdrawal Date</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($investments as $investment)
            <tr>
                <td>{{ $investment->id }}</td>
                <td>{{ $investment->country->name ?? 'N/A' }}</td>
                <td>{{ $investment->bank->bank_name ?? 'N/A' }}</td>
                <td>{{ $investment->currency->currency_name ?? 'N/A' }}</td>
                <td>{{ $investment->capital  }}</td>
                <td>
                    @if ($investment->rate_type === 'annual')
                        @php
                            $annualRate = $investment->interest_rate / 100;
                            $monthlyRate = (pow(1 + $annualRate, 1 / 12)) - 1;
                        @endphp
                        {{ round($monthlyRate * 100, 5) }}%
                    @else
                        {{ $investment->interest_rate }}%
                    @endif
                </td>
                <td>
                    {{ \App\Helpers\InvestmentHelper::convertToUSDOrDefault($investment, function ($capital, $rate, $months) {
                        $totalAmount = $capital * pow((1 + $rate), $months);
                        $monthlyInterest = $totalAmount - $capital;
                        return $monthlyInterest / $months;
                    }) }}
                </td>
                
                <td>
                    {{ \App\Helpers\InvestmentHelper::convertToUSDOrDefault($investment, function ($capital, $rate, $months) {
                        $totalAmount = $capital * pow((1 + $rate), $months);
                        $totalInterest = $totalAmount - $capital;
                        return $totalInterest;
                    }) }}
                </td>
                <td>{{ \App\Helpers\InvestmentHelper::convertToUSDOrDefault($investment, function ($capital, $rate, $months) {
                        return $capital * pow((1 + $rate), $months);
                    }) }}</td>
                <td>{{ \App\Helpers\InvestmentHelper::convertToUSDOrDefault($investment, function ($capital, $rate, $months, $taxRate) {
                        $totalAmount = $capital * pow((1 + $rate), $months);
                        $taxAmount = ($totalAmount * $taxRate) / 100;
                        return $totalAmount - ($rate * $taxAmount);
                    }) }}</td>
                <td>{{ $investment->deposit_date }}</td>
                <td>{{ \Carbon\Carbon::parse($investment->deposit_date)->addDays($investment->withdrawal_period ?? 0)->format('M j, Y') }}</td>
                <td>{{ $investment->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
