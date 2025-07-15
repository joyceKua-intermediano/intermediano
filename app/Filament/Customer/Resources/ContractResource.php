<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\ContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Filament\Tables\Columns\BadgeColumn;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Intermediano Contract';
    protected static ?string $pluralLabel = 'Intermediano Contract';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required(),
                Forms\Components\Select::make('quotation_id')
                    ->relationship('quotation', 'title')
                    ->required(),
                Forms\Components\TextInput::make('country_work')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('job_title')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\TextInput::make('gross_salary')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('contract_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('job_description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translated_job_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cluster_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->hidden(fn() => auth()->user()->company_id === null), // Show only if `company_id` exists
                Tables\Columns\TextColumn::make('partner.partner_name')
                    ->label('Partner')
                    ->sortable()
                    ->hidden(fn() => auth()->user()->partner_id === null), // Show only if `partner_id`
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation.title')
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
                Tables\Columns\TextColumn::make('contract_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cluster_name')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return preg_replace('/(?<!^)([A-Z])/', ' $1', $state);
                    }),
                BadgeColumn::make('signature')
                    ->sortable()
                    ->colors([
                        'success' => fn($state) => $state !== null,
                        'warning' => fn($state) => $state == 'Pending Signature',
                    ])
                    ->label('Signature Status')
                    ->formatStateUsing(fn($state) => $state !== 'Pending Signature' ? 'Signed' : 'Pending Signature'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // Tables\Actions\EditAction::make(),


                Tables\Actions\Action::make('uploadSignature')
                    ->label('Signature Pad')
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
                            ->directory('signatures/clients')
                            ->visibility('private')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->optimize('webp')
                            ->resize(50)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                $companyId = auth()->user()->company_id;
                                $partnerId = auth()->user()->partner_id;
                                $signaturePath = $companyId ? 'customer_' . $companyId : 'partner_' . $partnerId;
                                $fileName = $signaturePath . '.' . $file->getClientOriginalExtension();
                                $filePath = 'signatures/clients' . $fileName;
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
                    ->form(function ($record) {
                        $contractSettings = getContractTypeOptions($record->cluster_name);

                        return $contractSettings['visible']
                            ? [
                                Forms\Components\Select::make('contractType')
                                    ->label('Contract Type')
                                    ->options($contractSettings['options'])
                                    ->required(),
                            ]
                            : [];
                    })
                    ->action(function ($record, $data) {
                        $content = getClientContractFile($record);
                        $pdfPageMappings = [
                            'PartnerContractCanada' => [
                                'english_portuguese' => 'pdf.contract.canada.partner.english_portuguese',
                                'partner_english' => 'pdf.contract.canada.partner.english',
                                'english_spanish' => 'pdf.contract.canada.partner.english_spanish',
                                'english_french' => 'pdf.contract.canada.partner.english_french',
                            ],
                            'ClientContractCanada' => [
                                'tcw' => 'pdf.contract.canada.client.tcw',
                                'english_french' => 'pdf.contract.canada.client.english_french',
                                'english' => 'pdf.contract.canada.client.english',

                            ],
                        ];
                        $clusterName = $record->cluster_name;
                        $contractType = $data['contractType'] ?? null;
                        $pdfPage = $pdfPageMappings[$clusterName][$contractType] ?? $content['pdfPage'];

                        if (!$pdfPage) {
                            throw new \Exception('Invalid contract type or cluster name.');
                        }
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);

                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('es');
                        $record->translatedPosition = $tr->translate($record->companyContact->position ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $customerName = $record->partner->partner_name ?? $record->company->name;
                        $fileName = $startDateFormat . '_Contract with_' . $customerName . '_of employee_PR';
                        $footerDetails = [
                            'companyName' => $content['companyTitle'],
                            'address' => $content['address'],
                            'domain' => $content['domain'],
                            'mobile' => $content['mobile']
                        ];
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record, 'poNumber' => $contractTitle, 'footerDetails' => $footerDetails, 'is_pdf' => true]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            $fileName . '.pdf'
                        );
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            // 'create' => Pages\CreateContract::route('/create'),
            // 'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $customerCompanyID = auth()->user()->company_id;
        $customerPartnerID = auth()->user()->partner_id;
        $queryId = $customerCompanyID ?? $customerPartnerID;
        $queryColumn = $customerCompanyID ? 'company_id' : 'partner_id';
        $contractType = $customerCompanyID ? 'customer' : 'partner';
        // dd($contractType, $queryId, $queryColumn);
        $getEmployeeContract = Contract::where($queryColumn, $queryId)->where('contract_type', '=', $contractType);
        
        return $getEmployeeContract;
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
