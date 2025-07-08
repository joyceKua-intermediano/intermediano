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
                $domain = 'www.intermediano.com';
                break;
            case 'PartnerContractUruguay':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.partner';
                $domain = 'www.intermediano.com';
                break;
            case 'ClientContractUruguay':
                $mobile = '';
                $address = '';
                $companyTitle = 'Intermediano S.A.S.';
                $pdfPage = 'pdf.contract.uruguay.client';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoChileSPA':
                $mobile = '+1 514-907-5393';
                $address = 'Calle El Gobernador 20, Oficina 202, Providencia, Santiago, Chile';
                $companyTitle = 'Intermediano Chile SPA ';
                $pdfPage = 'pdf.contract.chile.client';
                $domain = 'www.intermediano.com';
                break;
            case 'ClientContractHongkong':
                $mobile = '+1 514-907-5393';
                $address = 'Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong';
                $companyTitle = 'Intermediano Hong Kong Limited';
                $pdfPage = 'pdf.contract.hongkong.customer';
                $domain = 'www.intermediano.com';
                break;
            case 'PartnerContractHongkong':
                $mobile = '+1 514-907-5393';
                $address = 'Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong';
                $companyTitle = 'Intermediano Hong Kong Limited';
                $pdfPage = 'pdf.contract.hongkong.partner';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoColombiaSAS':
                $mobile = '+1 514-907-5393';
                $address = 'Calle Carrera 9 #115-30, Edificio Tierra Firme Oficina 1745 Bogotá, Bogotá DC, Colombia';
                $companyTitle = 'Intermediano Colombia S.A.S';
                $pdfPage = 'pdf.contract.colombia.customer';
                $domain = 'www.intermediano.com';
                break;

            case 'IntermedianoDoBrasilLtda':
                $mobile = '+1 514-907-5393';
                $address = '';
                $companyTitle = 'Intermediano do Brasil Ltda.';
                $pdfPage = 'pdf.contract.brazil.customer';
                $domain = 'www.intermediano.com';
                break;


            default:
                $mobile = '';
                $address = '';
                $companyTitle = '';
                $pdfPage = '';
                $domain = 'sac@intermediano.com';
                break;
        }
        return [
            'companyTitle' => $companyTitle,
            'pdfPage' => $pdfPage,
            'mobile' => $mobile,
            'address' => $address,
            'domain' => $domain
        ];
    }
}