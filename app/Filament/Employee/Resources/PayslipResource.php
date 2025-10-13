<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\PayslipResource\Pages;
use App\Models\Payslip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('payslip_period')
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->url(function ($record) {
                        $path = "payslips/{$record->cluster}/{$record->file_name}";


                        return Storage::disk('r2')->temporaryUrl(
                            $path,
                            now()->addMinutes(5)
                        );
                    })
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $getEmployeePayslips = Payslip::where('employee_id', $employeeId);
        return $getEmployeePayslips;
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayslips::route('/'),

        ];
    }
}
