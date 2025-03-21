    <ul class="space-y-4">
        <li class="flex justify-between items-center border-b pb-2">
            <span class="font-medium text-gray-600">Account Name:</span>
            <span class="text-gray-800">{{ $record->name }}</span>
        </li>
        <li class="flex justify-between items-center border-b pb-2">
            <span class="font-medium text-gray-600">Bank Name:</span>
            <span class="text-gray-800">{{ $record->bankDetail->bank_name ?? 'N/A' }}</span>
        </li>
        <li class="flex justify-between items-center border-b pb-2">
            <span class="font-medium text-gray-600">Branch Name:</span>
            <span class="text-gray-800">{{ $record->bankDetail->branch_name ?? 'N/A' }}</span>
        </li>
        <li class="flex justify-between items-center border-b pb-2">
            <span class="font-medium text-gray-600">Account Number:</span>
            <span class="text-gray-800">{{ $record->bankDetail->account_number ?? 'N/A' }}</span>
        </li>
        <li class="flex justify-between items-center">
            <span class="font-medium text-gray-600">Account Type:</span>
            <span class="text-gray-800">{{ $record->bankDetail->account_type ?? 'N/A'  }}</span>
        </li>
    </ul>
