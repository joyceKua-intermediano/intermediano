<table>
    <thead>
    <tr>
        <th>{{ __('Opportunity Name') }}</th>
        <th>{{ __('Country') }}</th>
        <th>{{ __('Opportunity Type') }}</th>
        <th> {{ __('A2T') }} </th>
        <th> {{ __('Contact Name') }} </th>
        <th> {{ __('Lead source') }} </th>
        <th> {{ __('Lead status') }} </th>
        <th> {{ __('Number of contractors') }} </th>
        <th> {{ __('Estimated Tender Value ETV') }} </th>
        <th>{{ __('Close date') }}</th>
        <th>{{ __('Created date') }}</th>
        <th> {{ __('Lead Owner') }} </th>
        {{-- <th> {{ __('Email') }} </th>
        <th> {{ __('Close reason') }} </th> --}}
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->lead }}</td>
            <td>{{ $lead->country }}</td>
            <td>{{ $lead->opportunity_type }}</td>
            <td>{{ $lead->a2t == 1 ? 'Yes' : 'No' }}</td>
            <td>{{ $lead->contact?->fullname }}</td>
            <td>{{ $lead->lead_source }}</td>
            <td>{{ $lead->lead_status }}</td>
            <td>{{ $lead->number_of_contractors }}</td>
            <td>{{ $lead->estimated_tender_value }} </td>
            <td> {{ $lead->estimated_close_date ? date('d/m/Y', strtotime($lead->estimated_close_date )) : '' }} </td>
            <td>{{ $lead->created_at ? date('d/m/Y', strtotime($lead->created_at)) : ''}} </td>
            <td>{{ $lead->owner?->name }}</td>
            {{-- <td>{{ $lead->email }}</td>
            <td>{{ $lead->close_reason }}</td> --}}
        </tr>
    @endforeach
    </tbody>
</table>