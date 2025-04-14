<?php

if (!function_exists('camelCaseToWords')) {
    function camelCaseToWords($camelCaseString)
    {
        $readable = preg_replace('/(?<!^)([A-Z])/', ' $1', $camelCaseString);
        return ucfirst($readable);

    }
}