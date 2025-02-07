<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Consultant</th>
            <th>Position</th>
            <th>Industy Field</th>
            <th>Company</th>
            <th>Customer</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Partner</th>
            <th>Contact Status</th>
            <th>Created On</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $staff)
            <tr>
                <td>{{ $staff->id }}</td>
                <td>{{ $staff->consultant->name }}</td>
                <td>{{ $staff->country->name }}</td>
                <td>{{ $staff->position }}</td>
                <td>{{ $staff->intermedianoCompany->name }}</td>
                <td>{{ $staff->company->name }}</td>
                <td>{{ $staff->start_date }}</td>
                <td>{{ $staff->end_date }}</td>
                <td>{{ $staff->partner->partner_name ?? null }}</td>
                <td>{{ $staff->status === 1 ? 'On' : 'Off' }}</td>
                <td>{{ $staff->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
