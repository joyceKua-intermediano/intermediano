<?php 

namespace App\Http\Helpers\Helper;


class ChartColorHelper
{
    /**
     * Predefined color palette with country names as keys.
     */
    private static array $colors = [
        'brazil' => '#FF6384',
        'peru' => '#36A2EB',
        'colombia' => '#FFCE56',
        'canada' => '#4BC0C0',
        'costa rica' => '#9966FF',
        'ecuador' => '#FF9F40',
        'philippines' => '#E7E9ED',
        'uruguay' => '#FF5733',
        'chile' => '#C70039',
    ];

    /**
     * Get the color for a specific country.
     */
    public static function getColor(string $countryName): string
    {
        // Return the color if the country exists in the palette, otherwise fallback to a default
        return self::$colors[strtolower($countryName)] ?? '#cccccc'; // Default color if not defined
    }

    /**
     * Optionally provide the entire palette.
     */
    public static function getPalette(): array
    {
        return self::$colors;
    }
}
