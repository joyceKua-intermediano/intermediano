<?php

if (!function_exists('getClientContractFile')) {

    function getClientContractFile($record)
    {
        switch ($record->cluster_name) {
            case 'PartnerContractCanada':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.partner';
                break;
            case 'PartnerContractUruguay':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.partner';
                break;
            case 'ClientContractUruguay':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.client';
                break;
            case 'IntermedianoChileSPA':
                $mobile = '+1 514-907-5393';
                $address = 'Calle El Gobernador 20, Oficina 202, Providencia, Santiago, Chile';
                $companyTitle = 'Intermediano Chile SPA ';
                $pdfPage = 'pdf.contract.chile.client';
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