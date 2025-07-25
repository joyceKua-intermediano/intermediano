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
            case 'PartnerCostaRica':
                $mobile = '+1 514-907-5393';
                $address = 'Avenidas 2 y 4, calle 5, Escazú, San José, Costa Rica';
                $companyTitle = 'Intermediano S.R.L.';
                $pdfPage = 'pdf.contract.costa_rica.partner';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoCostaRica':
                $mobile = '+1 514-907-5393';
                $address = 'Avenidas 2 y 4, calle 5, Escazú, San José, Costa Rica';
                $companyTitle = 'Intermediano S.R.L.';
                $pdfPage = 'pdf.contract.costa_rica.client';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoEcuadorSAS':
                $mobile = '+1 514-907-5393';
                $address = 'Av Francisco Orellana E12-148 y Av 12 de Octubre, Oficina 206, Mariscal Sucre, Quito, Pichincha, Ecuador';
                $companyTitle = 'INTERMEDIANO ECUADOR SAS';
                $pdfPage = 'pdf.contract.ecuador.client';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoMexicoSC':
                $mobile = '+1 514-907-5393';
                $address = 'Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, 11590 CDMX, México';
                $companyTitle = 'Intermediano SA de CV';
                $pdfPage = 'pdf.contract.mexico.client';
                $domain = 'www.intermediano.com';
                break;
            case 'IntermedianoPeruSAC':
                $mobile = '+1 514-907-5393';
                $address = 'Avenida Paseo de Republica 3195 Oficina 401, San Isidro, Perú';
                $companyTitle = 'Intermediano Perú SAC';
                $pdfPage = 'pdf.contract.peru.client';
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