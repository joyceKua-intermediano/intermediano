<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerContractResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerContractResource\RelationManagers;
use App\Models\Contract;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Storage;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
class PartnerContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Partner Contract';

    protected static ?string $cluster = IntermedianoUruguay::class;
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('contract_type')
                    ->default('partner'),
                Forms\Components\Select::make('partner_id')
                    ->label('Partner')
                    ->relationship('partner', 'partner_name')
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoUruguay'))
                    ->required(),
                Forms\Components\Select::make('quotation_id')
                    ->relationship(
                        'quotation',
                        'title',
                        fn(Builder $query) => $query->where('cluster_name', 'PartnerUruguay')->where('is_payroll', '0')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn(Quotation $record) =>
                        "{$record->title} (" .
                        ($record->country->name ?? 'Unknown Country') .
                        ") (" .
                        ($record->is_freelance ? 'Freelancer' : 'Regular Employee') .
                        ")"
                    )
                    ->required(),
                Forms\Components\TextInput::make('country_work')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('job_title')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('start_date')
                    ->displayFormat('d-m-y')
                    ->placeholder('dd-mm-yy')
                    ->native(false),
                Forms\Components\DatePicker::make('end_date')
                    ->displayFormat('d-m-y')
                    ->placeholder('dd-mm-yy')
                    ->native(false),
                Forms\Components\TextInput::make('gross_salary')
                    ->mask(RawJs::make(<<<'JS'
                $money($input, '.', ',', 2)
            JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Hidden::make('cluster_name')
                    ->default('PartnerContractUruguay')
                    ->label('PartnerContractUruguay'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('partner.partner_name')
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
                TextColumn::make('signature_status')
                    ->label('Signature Status')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $employeeSigned = $record->signature !== 'Pending Signature';
                        $adminSigned = $record->admin_signature !== 'Pending Signature';

                        $employeeText = $employeeSigned ? 'Employee: Signed' : 'Employee: Pending';
                        $adminText = $adminSigned ? 'Admin: Signed' : 'Admin: Pending';

                        $employeeStyle = $employeeSigned
                            ? "background:#bbf7d0;color:#166534;"
                            : "background:#ffb84d;color:#854d0e;";

                        $adminStyle = $adminSigned
                            ? "background:#bbf7d0;color:#166534;"
                            : "background:#ffb84d;color:#854d0e;";

                        return "
                            <span style='display:inline-flex;align-items:center;padding:2px 8px;border-radius:9999px;font-size:0.75rem;font-weight:500;{$employeeStyle}margin-right:0.25rem'>
                                {$employeeText}
                            </span>
                            <span style='display:inline-flex;align-items:center;padding:2px 8px;border-radius:9999px;font-size:0.75rem;font-weight:500;{$adminStyle}'>
                                {$adminText}
                            </span>
                        ";
                    })
                    ->sortable(false)
                    ->searchable(false),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
                            ->directory('signatures/admin')
                            ->visibility('private')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->optimize('webp')
                            ->resize(50)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $record): string {

                                $contractId = $record->id;
                                $fileName = 'admin_' . $contractId . '.' . $file->getClientOriginalExtension();
                                $filePath = 'signatures/admin/' . $fileName;
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
                            'admin_signature' => $data['signature_file'],
                            'admin_signed_contract' => $data['signed_contract'],
                            'admin_signed_by' => auth()->user()->id
                        ]);
                    }),
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPage = 'pdf.contract.uruguay.partner';
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);

                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('es');
                        $record->translatedPosition = $tr->translate($record->companyContact->position ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contract with_' . $record->partner->partner_name . '_of employee_PR';
                        $footerDetails = [
                            'companyName' => 'Intermediano S.A.S.',
                            'address' => '',
                            'domain' => 'sac@intermediano.com',
                            'mobile' => ''
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
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPartnerContracts::route('/'),
            'create' => Pages\CreatePartnerContract::route('/create'),
            'edit' => Pages\EditPartnerContract::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $contractCluster = Contract::where('cluster_name', 'PartnerContractUruguay')->where('contract_type', 'partner');
        return $contractCluster;
    }

}
