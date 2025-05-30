<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class IntermedianoDoBrasilLtda extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Intermediano Group Companies';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Intermediano do Brasil Ltda';
    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Intermediano do Brasil Ltda");
    }

}
