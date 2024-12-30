<table>
    <thead>
    <tr>
        <th> {{ __("ID") }} </th>
        <th> {{ __("Company") }} </th>
        {{-- <th> {{ __("Surname") }} </th>
        <th> {{ __("Department") }} </th> --}}
        <th> {{ __("Main contact") }} </th>
        <th> {{ __("Job Title") }} </th>
        <th> {{ __("Email") }} </th>
        <th> {{ __("Mobile") }} </th>
        {{-- <th> {{ __("Phone") }} </th> --}}
        {{-- <th> {{ __("Whatsapp") }} </th> --}}
        {{-- <th> {{ __("Is main contact") }} </th> --}}
    </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
        <tr>
            <td> {{ $contact?->id }} </td>
            <td> {{ $contact?->company?->name }} </td>
            {{-- <td> {{ $contact?->surname }} </td>
            <td> {{ $contact?->department }} </td> --}}
            <td> {{ $contact?->contact_name }} {{ $contact?->surname }} </td>
            <td> {{ $contact?->position }} </td>
            <td> {{ $contact?->email }} </td>
            <td> {{ $contact?->mobile }} </td>
            {{-- <td> {{ $contact?->phone }} </td> --}}
            {{-- <td> {{ $contact?->whatsapp }} </td> --}}
            {{-- <td> {{ $contact?->is_main_contact }} </td> --}}
        </tr>
    @endforeach
    </tbody>
</table>