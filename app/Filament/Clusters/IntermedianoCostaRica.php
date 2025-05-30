<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoCostaRica extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Intermediano SRL CR';

    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano SRL CR");
    }
}
