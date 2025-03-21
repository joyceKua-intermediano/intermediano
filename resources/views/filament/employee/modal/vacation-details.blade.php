
<ul class="space-y-4">
    <li class="flex justify-between items-center border-b pb-2">
        <span class="font-medium text-gray-600">Accrued Vacation:</span>
        <span class="text-gray-800">{{ round($record->getAccruedVacation(), 2)}}</span>
    </li>
    <li class="flex justify-between items-center border-b pb-2">
        <span class="font-medium text-gray-600">Accrued Taken:</span>
        <span class="text-gray-800">{{ round($record->getTakenVacation(), 2)}}</span>
    </li>
    <li class="flex justify-between items-center border-b pb-2">
        <span class="font-medium text-gray-600">Accrued Balance:</span>
        <span class="text-gray-800">{{ round($record->getVacationBalance(), 2)}}</span>
    </li>
</ul>
