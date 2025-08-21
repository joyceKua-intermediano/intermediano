<?php

namespace App\Helpers;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use App\Models\Country;
use App\Models\ProvisionType;

class BrazilProvisionFormHelper
{
    public static function getProvisionRepeaterSchema(string $countryName): Repeater
    {
        return Repeater::make('payment_provisions')
            ->label('Payment Provisions')
            ->relationship('paymentProvisions')
            ->schema([
                Select::make('provision_type_id')
                    ->label('Provision Type')
                    ->required()
                    ->options(function (callable $get, callable $set) use ($countryName) {
                        $countryProvisionTypes = [
                            'Brazil' => [
                                '13th Salary',
                                'Vacation',
                                'Termination',
                                '1/3 Vacation Bonus',
                            ],
                            'Canada' => [
                                'Termination',
                                'Vacation',
                            ],
                            // Add more countries if needed
                        ];

                        $allowedNames = $countryProvisionTypes[$countryName] ?? [];

                        $allOptions = ProvisionType::whereIn('name', $allowedNames)
                            ->pluck('name', 'id');

                        $current = $get('provision_type_id');

                        $allSelected = collect($get('../../payment_provisions'))
                            ->pluck('provision_type_id')
                            ->filter()
                            ->reject(fn ($id) => $id === $current)
                            ->toArray();

                        return $allOptions->reject(fn ($name, $id) => in_array($id, $allSelected));
                    })
                    ->searchable(),

                TextInput::make('amount')
                    ->label('Amount (Local Currency)')
                    ->numeric()
                    ->required(),

                Hidden::make('country_id')
                    ->default(fn () => Country::where('name', $countryName)->value('id')),

                Hidden::make('cluster_name')
                    ->default(self::getClusterName()),
            ])
            ->columnSpanFull()
            ->columns(2)
            ->grid(2)
            ->createItemButtonLabel('Add Provision Payment');
    }

    protected static function getClusterName(): string
    {
        // Dummy implementation; replace with your actual logic
        return 'IntermedianoDoBrasilLtda';
    }
}
