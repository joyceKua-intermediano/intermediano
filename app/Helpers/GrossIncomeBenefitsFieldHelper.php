<?php

namespace App\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Concerns\CanBeLengthConstrained;

class GrossIncomeBenefitsFieldHelper extends TextInput
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->mask(\Filament\Support\RawJs::make(<<<'JS'
                $money($input, '.', ',', 2)
            JS))
            ->afterStateUpdated(function ($component, $state) {
                $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);
                $component->state($cleanedState);
            })
            ->default(0)
            ->required();
    }
}
