<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoMexicoSC extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?string $navigationLabel = 'Intermediano Mexico SA de CV';
    protected static ?int $navigationSort = 7;

    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano Mexico SA de CV");
    }
}
