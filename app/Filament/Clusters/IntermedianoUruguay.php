<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoUruguay extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?string $navigationLabel = 'Intermediano SAS UY';
    protected static ?int $navigationSort = 9;
    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano SAS UY");
    }
}
