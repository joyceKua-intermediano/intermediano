<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoHongkong extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?string $navigationLabel = 'Intermediano Hong Kong Limited';
    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano Hong Kong Limited");
    }
}
