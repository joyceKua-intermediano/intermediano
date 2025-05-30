<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoPeruSAC extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?string $navigationLabel = 'Intermediano Peru SAC';
    protected static ?int $navigationSort = 8;

    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano Peru SAC");
    }
}
