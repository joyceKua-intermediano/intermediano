<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoCanada extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Gate Intermediano Inc';
    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Gate Intermediano Inc");
    }

}
