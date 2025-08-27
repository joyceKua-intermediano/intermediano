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
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\DatePicker;
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
                EditAction::make()
                    ->modalHeading('Edit Payslip')
                    ->form([
                        Select::make('employee_id')
                            ->relationship('employee', 'name', fn($query) => $query->where('company', 'IntermedianoDoBrasilLtda'))
                            ->required(),
                        DatePicker::make('payslip_period')
                            ->displayFormat('Y-m')
                            ->mutateDehydratedStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('Y-m'))
                            ->required(),

                        FileUpload::make('file_path')
                            ->label('Payslip File')
                            ->disk('r2')
                            ->directory('payslips')
                            ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => $file->getClientOriginalName())
                            ->visibility('public')
                            ->required(),
                        Hidden::make('cluster')->default('IntermedianoDoBrasilLtda'),
                    ]),

                // Delete action

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
