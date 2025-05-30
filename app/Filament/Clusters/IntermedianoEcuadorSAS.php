<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoEcuadorSAS extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?string $navigationLabel = 'Intermediano Ecuador SAS';
    protected static ?int $navigationSort = 5;
    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano Ecuador SAS");
    }
}
