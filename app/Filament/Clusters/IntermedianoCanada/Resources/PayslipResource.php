<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources;

use App\Filament\Clusters\IntermedianoCanada;
use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\Pages;
use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\RelationManagers;
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

    protected static ?string $cluster = IntermedianoCanada::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),

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
            ]);
    }


    public static function getEloquentQuery(): Builder
    {
        $payslips = Payslip::where('cluster', self::getClusterName());
        return $payslips;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayslips::route('/'),
        ];
    }
    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
