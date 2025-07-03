<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\EmployeeContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Http\UploadedFile;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\URL;

class EmployeeContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Contract';
    protected static ?string $pluralLabel = 'Contract';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_work')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross_salary')
                    ->searchable(),
                BadgeColumn::make('signature')
                    ->sortable()
                    ->colors([
                        'success' => fn($state) => $state !== null && $state !== 'Pending Signature',
                        'warning' => fn($state) => $state === 'Pending Signature',
                    ])
                    ->label('Employee Signature')
                    ->formatStateUsing(fn($state) => $state !== 'Pending Signature' ? 'Signed' : 'Pending Signature'),

                BadgeColumn::make('admin_signature')
                    ->sortable()
                    ->colors([
                        'success' => fn($state) => $state !== null && $state !== 'Pending Signature',
                        'warning' => fn($state) => $state === 'Pending Signature',
                    ])
                    ->label('Admin Signature')
                    ->formatStateUsing(fn($state) => $state !== 'Pending Signature' ? 'Signed' : 'Pending Signature'),
            ])

            ->actions([
                Tables\Actions\Action::make('view_contract')
                    ->label('View Contract')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
                        $content = getContractModalContent($record);
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('en');
                        $record->translatedPosition = $tr->translate($record->job_title ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contrato Individual de ' . $record->employee->name . '_of employee';
                        $viewModal = 'filament.quotations.brasil_modal';
                        $footerDetails = [
                            'companyName' => $content['companyTitle'],
                            'address' => '',
                            'domain' => 'www.intermediano.com',
                            'mobile' => ''
                        ];
                        return view($content['pdfPage'], [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'is_pdf' => false,
                            'footerDetails' => $footerDetails,
                        ]);
                    }),
                Tables\Actions\Action::make('uploadSignature')
                    ->label('Upload Signature')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        SignaturePad::make('signature_data')
                            ->label(__('Sign here'))
                            ->downloadable(false)
                            ->undoable()
                            ->live()
                            // ->visible(fn($get) => empty($get('signature_file')))
                            ->confirmable(true)
                            ->afterStateUpdated(function ($state, $livewire) {
                                if ($state) {
                                    $base64_string = substr($state, strpos($state, ',') + 1);
                                    $image_data = base64_decode($base64_string);
                                    $file_name = Str::random(40) . '.png';
                                    $file = self::createTemporaryFileUploadFromUrl($image_data, $file_name);
                                    $livewire->dispatch('signature-uploaded', $file);
                                }
                            })
                            ->columnSpan(4),

                        Forms\Components\FileUpload::make('signature_file')
                            ->label('')
                            ->disk('private')
                            ->directory('signatures/employee')
                            ->visibility('private')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->optimize('webp')
                            ->resize(50)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                $fileName = 'employee_' . auth()->user()->id . '.' . $file->getClientOriginalExtension();
                                $filePath = 'signatures/employee/' . $fileName;
                                if (Storage::disk('private')->exists($filePath)) {
                                    Storage::disk('private')->delete($filePath);
                                }
                                return $fileName;
                            })
                            ->required()
                            ->extraAttributes(['style' => 'display: none;'])

                            ->extraAlpineAttributes([
                                'x-data' => '{ fileReady: false }',
                                'x-on:signature-uploaded.window' => '
                                const pond = FilePond.find($el.querySelector(".filepond--root"));
                                fileReady = false; // Reset to false before starting
                                pond.removeFiles({ revert: false });
                                pond.addFile($event.detail).then(() => {
                                    fileReady = true; // Set to true once the file is fully uploaded
                                }).catch(error => {
                                    console.error("File upload failed:", error);
                                    fileReady = false; // Ensure it’s marked as not ready in case of failure
                                });
                                  ',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\Hidden::make('signed_contract')
                            ->default(now()->toDateTimeString()),
                    ])
                    ->action(function ($record, $data) {
                        $record->update([
                            'signature' => $data['signature_file'],
                            'signed_contract' => $data['signed_contract'],
                        ]);
                    }),
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $content = getContractModalContent($record);

                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('en');
                        $record->translatedPosition = $tr->translate($record->job_title ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contrato Individual de ' . $record->employee->name . '_of employee';
                        $footerDetails = [
                            'companyName' => $content['companyTitle'],
                            'address' => '',
                            'domain' => 'www.intermediano.com',
                            'mobile' => ''
                        ];
                        $pdf = Pdf::loadView($content['pdfPage'], [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'is_pdf' => true,
                            'footerDetails' => $footerDetails,


                        ]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            $fileName . '.pdf'
                        );
                    }),

            ])
            ->searchable(false);
    }

    public static function createTemporaryFileUploadFromUrl($imageData, $filename): string
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload');
        file_put_contents($tempFilePath, $imageData);

        $mimeType = mime_content_type($tempFilePath);
        $tempFile = new UploadedFile($tempFilePath, basename($filename), $mimeType, null, true);

        $path = Storage::putFile('livewire-tmp', $tempFile);

        $file = TemporaryUploadedFile::createFromLivewire($path);

        return URL::temporarySignedRoute(
            'livewire.preview-file',
            now()->addMinutes(30),
            ['filename' => $file->getFilename()]
        );
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
            'index' => Pages\ListEmployeeContracts::route('/'),
            'create' => Pages\CreateEmployeeContract::route('/create'),
            'edit' => Pages\EditEmployeeContract::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $getEmployeeExpenses = Contract::where('employee_id', $employeeId)->where('is_sent_to_employee', true);
        return $getEmployeeExpenses;
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }
}
