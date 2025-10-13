<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource;
use App\Models\Payslip;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                        ->default('intermedianoCanada'),
                ])
                ->action(function (array $data) {
                    $cluster = $data['cluster'];
                    $filePath = $data['file_path']; // already uploaded to R2
                    $fileName = basename($filePath);
                    $newPath = "payslips/{$cluster}/{$fileName}";
                    Storage::disk('r2')->move($filePath, $newPath);
                    Payslip::create([
                        'cluster' => $cluster,
                        'file_name' => $fileName, // readable name
                        'file_path' => $filePath, // full R2 object key
                    ]);
                }),
        ];
    }
}
