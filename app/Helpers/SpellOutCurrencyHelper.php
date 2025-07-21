<?php

if (!function_exists('spellOutCurrency')) {
    function spellOutCurrency(float $amount, string $locale = 'en', string $currencyLabel = 'Reais'): string
    {
        $formatter = new \NumberFormatter($locale, \NumberFormatter::SPELLOUT);

        $intPart = floor($amount);
        $decimalPart = round(($amount - $intPart) * 100);

        $intWords = $formatter->format($intPart);
        $decimalWords = $formatter->format($decimalPart);

        $intWords = mb_strtolower($intWords, 'UTF-8');
        $decimalWords = mb_strtolower($decimalWords, 'UTF-8');

        if ($locale === 'pt_BR') {
            $decimalWords = str_replace('catorze', 'quatorze', $decimalWords);
        }

        $formattedAmount = match ($currencyLabel) {
            'Reais' => 'R$ ' . number_format($amount, 2, ',', '.'),
            default => '$' . number_format($amount, 2, '.', ','),
        };

        $separator = $locale === 'pt_BR' ? 'vírgula' : 'point';

        return "$formattedAmount ($intWords $separator $decimalWords $currencyLabel)";
    }
}