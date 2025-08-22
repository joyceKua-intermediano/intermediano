<?php


if (!function_exists('getContractTypeOptions')) {
    function getContractTypeOptions($clusterName)
    {
        $contractOptions = [
            'PartnerContractCanada' => [
                'visible' => true,
                'options' => [
                    'partner_english' => '(English)',
                    'english_portuguese' => '(English - Portuguese)',
                    'english_spanish' => '(English - Spanish)',
                    'english_french' => '(English - French)',
                ],
            ],
            'ClientContractCanada' => [
                'visible' => true,
                'options' => [
                    // 'tcw' => 'TCW',
                    // 'english_french' => 'English - French',
                    'english' => 'English',
                ],
            ],
        ];

        return $contractOptions[$clusterName] ?? [
            'visible' => false,
            'options' => [],
        ];
    }
}
