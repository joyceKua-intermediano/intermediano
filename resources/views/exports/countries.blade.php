<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Country</th>
            <th>Currency</th>
            <th>Bank Name</th>
            <th>Created On</th>
            <th>Real-Time Conversion</th>
            <th>Exchange Rate</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country)
            <tr>
                <td>{{ $country->id }}</td>
                <td>{{ $country->name }}</td>
                <td>
                    @foreach ($country->currencies as $currency)
                        {{ $currency->currency_name }}@if (!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($country->banks as $bank)
                        {{ $bank->bank_name }}@if (!$loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $country->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $country->use_real_time_conversion ? 'Yes' : 'No' }}</td>
                <td>{{ $country->exchange_rate }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
