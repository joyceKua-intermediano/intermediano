<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Income Tax Rate</th>
            <th>Currency Name</th>
            <th>Bank Name</th>
            <th>Created On</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country)
            <tr>
                <td>{{ $country->id }}</td>
                <td>{{ $country->name }}</td>
                <td>{{ $country->income_tax_rate }}</td>
                <td>
                    @foreach ($country->currencies as $currency)
                        {{ $currency->currency_name }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($country->banks as $bank)
                        {{ $bank->bank_name }}<br>
                    @endforeach
                </td>
                <td>{{ $country->created_at }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
