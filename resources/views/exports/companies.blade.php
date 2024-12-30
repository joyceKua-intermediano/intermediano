<table>
    <thead>
    <tr>
        <th>{{ __('Company Name') }}</th>
        <th> {{ __('Country') }} </th>
        <th> {{ __('Field of industry') }} </th>
        <th> {{ __('Website') }} </th>
        <th> {{ __("Department") }} </th>
        <th> {{ __("Main Contact") }} </th>
        <th> {{ __("Job Title") }} </th>
        <th> {{ __("Email") }} </th>
        <th> {{ __("Mobile") }} </th>
        {{-- <th> {{ __("Phone") }} </th> --}}
        {{-- <th> {{ __("Whatsapp") }} </th> --}}

        {{-- <th> {{ __('Tax ID') }} </th> --}}
        {{-- <th> {{ __('State') }} </th>
        <th> {{ __('City') }} </th>
        <th> {{ __('Postal code') }} </th> --}}
        {{-- <th> {{ __('Address') }} </th> --}}
        {{-- <th>{{ __('Number of employees') }}</th> --}}
    </tr>
    </thead>
    <tbody>
    @foreach($companies as $company)
        <tr>
            <td>{{ $company->name }}</td>
            <td>{{ $company->country }}</td>
            <td>{{ $company->field_of_industry }} </td>
            <td>{{ $company->website }}</td>
            <td>{{ $company->main_contact?->department }} </td>
            <td> {{ $company->main_contact?->contact_name }} {{ $company->main_contact?->surname }} </td>
            <td> {{ $company->main_contact?->position }} </td>
            <td> {{ $company->main_contact?->email }} </td>
            <td> {{ $company->main_contact?->mobile }} </td>
            {{-- <td> {{ $company->main_contact?->phone }} </td> --}}
            {{-- <td> {{ $company->main_contact?->whatsapp }} </td> --}}

            {{-- <td>{{ $company->tax_id }}</td> --}}
            {{-- <td>{{ $company->state }}</td>
            <td>{{ $company->city }}</td>
            <td>{{ $company->postal_code }}</td> --}}
            {{-- <td>{{ $company->address }}</td> --}}
            {{-- <td>{{ $company->number_of_employees }} </td> --}}

        </tr>
    @endforeach
    </tbody>
</table>