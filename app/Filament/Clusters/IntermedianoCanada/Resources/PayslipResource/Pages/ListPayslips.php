<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource;
use App\Models\Payslip;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class ListPayslips extends ListRecords
{
    protected static string $resource = PayslipResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('upload')
                ->label('Upload Payslip')
                ->color('primary')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    Select::make('employee_id')
                        ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoCanada'))
                        ->required(),
                    DatePicker::make('payslip_period')
                        ->displayFormat('Y-m-d')
                        ->placeholder('yy-mm-dd')
                        ->native(false)
                        ->placeholder('Payslip Period'),

                    FileUpload::make('file_path')
                        ->label('Payslip File')
                        ->disk('r2') // directly store in your R2 disk
                        ->directory('payslips')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            // Keep the original readable filename
                            return $file->getClientOriginalName();
                        })
                        ->visibility('public')
                        ->required(),
                    Hidden::make('cluster')
                        ->default('IntermedianoCanada'),
                ])
                ->action(function (array $data) {
                    $cluster = $data['cluster'];
                    $filePath = $data['file_path'];
                    $fileName = basename($filePath);
                    $newPath = "payslips/{$cluster}/{$fileName}";
                    Storage::disk('r2')->move($filePath, $newPath);
                    Payslip::create([
                        'employee_id' => $data['employee_id'],
                        'payslip_period' => $data['payslip_period'],
                        'cluster' => $cluster,
                        'file_name' => $fileName,
                        'file_path' => $newPath,
                    ]);
                }),
        ];
    }
}
