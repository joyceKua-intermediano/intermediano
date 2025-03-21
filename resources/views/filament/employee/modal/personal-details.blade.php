<div class="space-y-4">
    <!-- Personal Details -->
    <div class="grid grid-cols-2 gap-4">
        <ul class="space-y-4">
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Civil Status:</span>
                <span class="text-gray-800">{{ $record->personalInformation->civil_status ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Date of Birth:</span>
                <span class="text-gray-800">{{ $record->personalInformation->date_of_birth ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Nationality:</span>
                <span class="text-gray-800">{{ $record->personalInformation->nationality ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Address:</span>
                <span class="text-gray-800">{{ $record->personalInformation->address ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">City:</span>
                <span class="text-gray-800">{{ $record->personalInformation->city ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">State:</span>
                <span class="text-gray-800">{{ $record->personalInformation->state ?? 'N/A' }}</span>
            </li>
        </ul>
        <ul class="space-y-4">
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Country:</span>
                <span class="text-gray-800">{{ $record->personalInformation->country ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Postal Code:</span>
                <span class="text-gray-800">{{ $record->personalInformation->postal_code ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Phone:</span>
                <span class="text-gray-800">{{ $record->personalInformation->phone ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Mobile:</span>
                <span class="text-gray-800">{{ $record->personalInformation->mobile ?? 'N/A' }}</span>
            </li>
            <li class="flex justify-between items-center border-b pb-2">
                <span class="font-medium text-gray-600">Education:</span>
                <span class="text-gray-800">
                    {{ $record->personalInformation->education_attainment ?? 'N/A' }}
                    ({{ $record->personalInformation->education_status ?? 'N/A' }})
                </span>
            </li>
            <li class="flex justify-between items-center">
                <span class="font-medium text-gray-600">Number of Dependents:</span>
                <span class="text-gray-800">{{ $record->personalInformation->number_of_dependents ?? 'N/A' }}</span>
            </li>
        </ul>
    </div>
    


    <!-- Dependents -->
    <div>
        <h4 class="text-lg font-bold text-gray-600 border-b pb-2">Dependents</h4>
        <table class="w-full mt-2 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-left text-sm font-medium text-gray-600">Full Name</th>
                    <th class="border border-gray-300 px-3 py-2 text-left text-sm font-medium text-gray-600">Relationship</th>
                    <th class="border border-gray-300 px-3 py-2 text-left text-sm font-medium text-gray-600">Date of Birth</th>
                    <th class="border border-gray-300 px-3 py-2 text-left text-sm font-medium text-gray-600">Tax ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->dependents as $dependent)
                <tr>
                    <td class="border border-gray-300 px-3 py-2 text-sm text-gray-700">{{ $dependent->full_name }}</td>
                    <td class="border border-gray-300 px-3 py-2 text-sm text-gray-700">{{ $dependent->relationship }}</td>
                    <td class="border border-gray-300 px-3 py-2 text-sm text-gray-700">{{ $dependent->date_of_birth }}</td>
                    <td class="border border-gray-300 px-3 py-2 text-sm text-gray-700">{{ $dependent->tax_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
