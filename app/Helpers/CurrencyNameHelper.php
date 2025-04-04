<?php

if (!function_exists('getCurrencyByCompany')) {
    function getCurrencyByCompany($company)
    {

        $currenyName = '';
        switch ($company) {
            case 'IntermedianoDoBrasilLtda':
                $currenyName = 'BRL';
                break;
            case 'IntermedianoColombiaSAS':
                $currenyName = 'COP';
                break;
            default:
                $currenyName = '';
                break;
        }
        return $currenyName;
    }
}