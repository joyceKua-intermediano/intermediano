<div class="p-4">
    <h2 class="text-lg font-semibold">Document Details</h2>
    <div class="mt-4 grid grid-cols-2 gap-4 border-b pb-4">
        <div>
            <span class="font-medium text-gray-600">Personal ID:</span>
            <span class="text-gray-800">{{ $record->document->personal_id ?? 'N/A' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Tax ID:</span>
            <span class="text-gray-800">{{ $record->document->tax_id ?? 'N/A' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Organism:</span>
            <span class="text-gray-800">{{ $record->document->organism ?? 'N/A' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Expiration Date:</span>
            <span class="text-gray-800">{{ $record->document->expiration ?? 'N/A' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Other Info:</span>
            <span class="text-gray-800">{{ $record->document->other ?? 'N/A' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Driver License:</span>
            <span class="text-gray-800">{{ $record->document && $record->document->is_driver_license ? 'Yes' : 'No' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Has Insurance:</span>
            <span class="text-gray-800">{{ $record->document && $record->document->has_insurance ? 'Yes' : 'No' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-600">Category:</span>
            <span class="text-gray-800">{{ $record->document->category ?? 'N/A' }}</span>
        </div>
    </div>

    <h2 class="text-lg font-semibold mt-6">Documents Uploaded Files</h2>
    <table class="min-w-full mt-4 border-collapse border border-gray-200 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Document Type</th>
                <th class="border border-gray-300 px-4 py-2 text-left">File Name</th>
                {{-- <th class="border border-gray-300 px-4 py-2 text-left">Actions</th> --}}
            </tr>
        </thead>
        <tbody>

            @forelse($record->employeeFiles as $file)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst(str_replace('_', ' ', $file->document_type)) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ $file->original_file_name }}
                        </a>
                    </td>
                    {{-- <td class="border border-gray-300 px-4 py-2">
                        <button 
                            type="button" 
                            class="text-red-500 hover:underline"
                            onclick="deleteDocument({{ $file->id }})"
                        >
                            Delete
                        </button>
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">
                        No files uploaded yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <h2 class="text-lg font-semibold mt-6">Social Security Uploaded Files</h2>

    <table class="min-w-full mt-4 border-collapse border border-gray-200 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Document Type</th>
                <th class="border border-gray-300 px-4 py-2 text-left">File Name</th>
                {{-- <th class="border border-gray-300 px-4 py-2 text-left">Actions</th> --}}
            </tr>
        </thead>
        <tbody>

                <tr>
                    @if(isset($record->socialSecurityInfo) && !empty($record->socialSecurityInfo['health_fund_file']))
                    <td class="border border-gray-300 px-4 py-2">Health Fund</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ Storage::url($record->socialSecurityInfo['health_fund_file']) }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ basename($record->socialSecurityInfo['health_fund_file']) }}
                        </a>
                    </td>  
                    @endif
                </tr>
                <tr>
                    @if(isset($record->socialSecurityInfo) && !empty($record->socialSecurityInfo['pension_fund_file']))

                    <td class="border border-gray-300 px-4 py-2">Pension Fund</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ Storage::url($record->socialSecurityInfo['pension_fund_file']) }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ basename($record->socialSecurityInfo['health_fund_file']) }}
                        </a>
                    </td>  
                    @endif
                </tr>
                <tr>
                    @if(isset($record->socialSecurityInfo) && !empty($record->socialSecurityInfo['severance_fund_file']))
                    <td class="border border-gray-300 px-4 py-2">Severance Fund</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ Storage::url($record->socialSecurityInfo['health_fund_file']) }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ basename($record->socialSecurityInfo['severance_fund_file']) }}
                        </a>
                    </td>  
                    @endif
                </tr>
                <tr>
                    @if(isset($record->socialSecurityInfo) && !empty($record->socialSecurityInfo['social_security_file']))
                    <td class="border border-gray-300 px-4 py-2">Social Insurance Number</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ Storage::url($record->socialSecurityInfo['social_security_file']) }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ basename($record->socialSecurityInfo['social_security_file']) }}
                        </a>
                    </td>  
                    @endif
                </tr>
                <tr>
                    @if(!isset($record->socialSecurityInfo))
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">
                            No files uploaded yet.
                        </td>
                    </tr>
                    @endif
                </tr>
        </tbody>
    </table>
</div>

<script>
    function deleteDocument(id) {
        if (confirm("Are you sure you want to delete this document?")) {
            // Perform delete action using an AJAX call or form submission
            console.log(`Deleting document with ID: ${id}`);
        }
    }
</script>
