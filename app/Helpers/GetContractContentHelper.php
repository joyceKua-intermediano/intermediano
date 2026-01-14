<?php

if (!function_exists('getContractModalContent')) {

    function getContractModalContent($record)
    {
        $contractQuotationType = $record->is_integral;
        $TCWEmployeeIds = [55, 56, 57, 58, 59, 60, 61, 62];

        switch ($record->cluster_name) {
            case in_array($record->employee_id, $TCWEmployeeIds):
                $companyTitle = 'Intermediano do Brasil Ltda.';
                $mobile = '+1 514-907-5393';
                $address = '';
                $pdfPage = 'pdf.contract.brazil.2026_intermediano_labor_agreement_REV';
                break;
            case 'IntermedianoDoBrasilLtda':
                $companyTitle = 'Intermediano do Brasil Ltda.';
                $pdfPage = $record->end_date == null ? 'pdf.contract.brazil.undefined_employee' : 'pdf.contract.brazil.defined_employee';
                $mobile = '+1 514-907-5393';
                $address = '';
                break;
            case 'IntermedianoColombiaSAS':
                $companyTitle = 'Intermediano Colombia SAS.';
                $mobile = '+1 514-907-5393';
                $address = 'Calle Carrera 9 #115-30, Edificio Tierra Firme Oficina 1745 Bogotá, Bogotá DC, Colombia';
                if ($contractQuotationType === 0) {
                    $pdfPage = $record->end_date === null
                        ? 'pdf.contract.colombia.ordinary_undefined_employee'
                        : 'pdf.contract.colombia.ordinary_defined_employee';
                } elseif ($contractQuotationType === 1) {
                    $pdfPage = $record->end_date === null
                        ? 'pdf.contract.colombia.integral_undefined_employee'
                        : 'pdf.contract.colombia.integral_defined_employee';
                } else {
                    $pdfPage = '';
                }
                break;
            case 'IntermedianoHongkong':
                $mobile = '';
                $address = 'Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong';
                $companyTitle = 'Intermediano Hong Kong Limited';
                $pdfPage = 'pdf.contract.hongkong.employee';
                break;
            case 'ClientContractHongkong':
                $mobile = '';
                $address = 'Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong';
                $companyTitle = 'Intermediano Hong Kong Limited';
                $pdfPage = 'pdf.contract.hongkong.customer';
                break;
            case 'PartnerContractHongkong':
                $mobile = '';
                $address = 'Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan, Hong Kong';
                $companyTitle = 'Intermediano Hong Kong Limited';
                $pdfPage = 'pdf.contract.hongkong.partner';
                break;
            case 'IntermedianoChileSPA':
                $mobile = '+1 514-907-5393';
                $address = 'Calle El Gobernador 20, Oficina 202, Providencia, Santiago, Chile';
                $companyTitle = 'Intermediano Chile SPA';
                $pdfPage = 'pdf.contract.chile.consultant';
                break;
            case 'IntermedianoPeruSAC':
                $mobile = '+1 514-907-5393';
                $address = 'Avenida Paseo de Republica 3195 Oficina 401, San Isidro, Perú';
                $companyTitle = 'Intermediano Perú SAC';
                $pdfPage = 'pdf.contract.peru.consultant';
                break;
            case 'IntermedianoEcuadorSAS':
                $mobile = '+1 514-907-5393';
                $address = 'Av Francisco Orellana E12-148 y Av 12 de Octubre, Oficina 206, Mariscal Sucre, Quito, Pichincha, Ecuador';
                $companyTitle = 'INTERMEDIANO ECUADOR SAS';
                $pdfPage = 'pdf.contract.ecuador.consultant';
                break;
            case 'IntermedianoMexicoSC':
                $mobile = '+1 514-907-5393';
                $address = 'Calzada Gral. Mariano Escobedo 476-piso 12, Chapultepec Morales, Verónica Anzúres, Miguel Hidalgo, 11590 CDMX, México';
                $companyTitle = 'Intermediano SA de CV';
                $pdfPage = 'pdf.contract.mexico.consultant';
                break;
            case 'IntermedianoCanada':
                $mobile = '+1 514-907-5393';
                $address = '4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada';
                $companyTitle = 'Gate Intermediano Inc.';
                $pdfPage = 'pdf.contract.canada.consultant';
                break;
            case 'IntermedianoCostaRica':
                $mobile = '+1 514-907-5393';
                $address = 'Avenidas 2 y 4, calle 5, Escazú, San José, Costa Rica';
                $companyTitle = 'Intermediano S.R.L.';
                $pdfPage = 'pdf.contract.costa_rica.consultant';
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