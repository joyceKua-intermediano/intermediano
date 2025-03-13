<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\VacationRequestResource\Pages;
use App\Filament\Customer\Resources\VacationRequestResource\RelationManagers;
use App\Models\VacationRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;

class VacationRequestResource extends Resource
{
    protected static ?string $model = VacationRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_days')
                    ->searchable(),
                BadgeColumn::make('status')
                    ->sortable()
                    ->colors([
                        'primary' => fn($state) => $state === 'pending',
                        'success' => fn($state) => $state === 'approved',
                        'danger' => fn($state) => $state === 'rejected',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->action(function (VacationRequest $record) {
                        $record->status = 'approved';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn(VacationRequest $record): bool => $record->status !== 'approved' && $record->status !== 'rejected'),
                Action::make('reject')
                    ->label('Reject')
                    ->action(function (VacationRequest $record) {
                        $record->status = 'rejected';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->visible(fn(VacationRequest $record): bool => $record->status !== 'rejected' && $record->status !== 'approved'),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVacationRequests::route('/'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
