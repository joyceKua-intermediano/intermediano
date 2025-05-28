<?php

if (!function_exists('getClientContractFile')) {

    function getClientContractFile($record)
    {
        switch ($record->cluster_name) {

            case 'PartnerUruguay':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.partner';
                break;
            default:
                $mobile = '';
                $address = '';
                $companyTitle = '';
                $pdfPage = '';
                break;
        }
        return [
            'companyTitle' => $companyTitle,
            'pdfPage' => $pdfPage,
            'mobile' => $mobile,
            'address' => $address
        ];
    }
}