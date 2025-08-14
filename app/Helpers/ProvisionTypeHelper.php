<?php

if (!function_exists('getProvisionType')) {
    function getProvisionType(?string $country): array
    {
        $countryAllowedMap = [
            'Brazil' => [
                '13th Salary',
                'Vacation',
                'Termination',
                '1/3 Vacation Bonus',
            ],
            'Panama' => [
                'Christmas bonus',
                'Vacation',
                'Forewarning',
                'Severance',
                'Seniority',
            ],
            'Nicaragua' => [
                'Christmas bonus',
                'Vacation',
                'Compensation',
            ],
            'Dominican Republic' => [
                '13th Salary',
                'Annual Bonus',
                'Notice period',
                'Unemployment',
                'Vacation',
            ],
        ];

        return $countryAllowedMap[$country] ?? [];
    }
}