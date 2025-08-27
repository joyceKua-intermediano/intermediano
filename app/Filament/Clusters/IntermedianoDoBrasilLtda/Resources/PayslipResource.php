<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources;

use App\Filament\Clusters\IntermedianoDoBrasilLtda;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\PayslipResource\Pages;
use App\Models\Payslip;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;


class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoDoBrasilLtda::class;


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payslip_period')
                    ->label('Payroll Period')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                // Delete action
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->url(function ($record) {
                        $path = "payslips/{$record->cluster}/{$record->file_name}";

                        // Debug here:
            
                        return Storage::disk('r2')->temporaryUrl(
                            $path,
                            now()->addMinutes(5)
                        );
                    })
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-tray'),
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
            'index' => Pages\ListPayslips::route('/'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $payslips = Payslip::where('cluster', self::getClusterName());
        return $payslips;
    }
    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
