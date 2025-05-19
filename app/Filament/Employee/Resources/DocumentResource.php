<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\DocumentResource\Pages;
use App\Filament\Employee\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('employee_id')
                    ->default(auth()->user()->id),
                Forms\Components\TextInput::make('personal_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('organism')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tax_id')
                    ->label(auth()->user()->company === 'IntermedianoMexicoSC' ? 'Tax ID (RFC)' : 'Tax ID')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('expiration'),
                Forms\Components\TextInput::make('other')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('has_insurance')
                    ->label('Health Insurance')
                    ->inline(false)
                    ->required(),
                Forms\Components\Toggle::make('is_driver_license')
                    ->label('Driver License')
                    ->inline(false)
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255)
                    ->default(null),

                Repeater::make('documents')
                    ->relationship('employeeFiles')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        Select::make('document_type')
                            ->label('Document Type')
                            ->options([
                                'photo_3x4' => '3x4 Photo',
                                'copy_of_id' => 'Copy of ID',
                                'copy_of_tax_id' => 'Copy of Tax ID',
                                'copy_of_voter_registration' => 'Copy of Voter Registration',
                                'no_record_of_pis' => 'No Record of PIS',
                                'copy_of_registration_certificate' => 'Copy of Registration Certificate',
                                'copy_of_birth_or_marriage_certificate' => 'Copy of Birth or Marriage Certificate',
                                'copy_of_work_permit' => 'Copy of Work Permit',
                                'proof_of_residency' => 'Proof of Residency',
                                'copy_of_birth_certificate_of_children' => 'Copy of Birth Certificate of Children',
                                'medical_admission_exam' => 'Medical Admission Exam',
                            ])
                            ->required(),
                        FileUpload::make('file_path')
                            ->label('File')
                            ->directory(fn() => 'employees/' . auth()->id() . '/documents')
                            ->resize(50)
                            ->optimize('webp')
                            ->required()
                            ->storeFileNamesIn('original_file_name')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, Get $get) {
                                $documentType = $get('document_type') ?? 'unknown';
                                $extension = $file->getMimeType() === 'application/pdf'
                                    ? 'pdf'
                                    : 'webp';

                                $fileName = auth()->user()->name . '_' . $documentType . '.' . $extension;
                                $filePath = 'employees/' . auth()->id() . '/documents' . $fileName;

                                if (Storage::disk('public')->exists($filePath)) {
                                    Storage::disk('public')->delete($filePath);
                                }
                                return $fileName;
                            }),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
                    ->collapsed(false)
                    ->orderable('id')
                    ->defaultItems(1),
                Forms\Components\Fieldset::make('BankingDetail')
                    ->relationship('bankingDetail')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        Forms\Components\TextInput::make('bank_name'),
                        Forms\Components\TextInput::make('bank_code')->label('Interbank Code (Clave interbancaria)'),
                        Forms\Components\TextInput::make('branch_name'),
                        Forms\Components\TextInput::make('account_number'),
                        Forms\Components\Select::make('account_type')
                            ->options([
                                'Savings' => 'Savings',
                                'Checking' => 'Checking',
                            ])
                    ]),


                Forms\Components\Fieldset::make('Social Security Infos')
                    ->relationship('socialSecurityInfo')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        TextInput::make('health_fund'),
                        self::createFileUpload('health_fund_file', 'health_fund'),

                        TextInput::make('pension_fund'),
                        self::createFileUpload('pension_fund_file', 'pension_fund_file'),

                        TextInput::make('severance_fund'),
                        self::createFileUpload('severance_fund_file', 'severance_fund_file'),

                        TextInput::make('curp'),
                        self::createFileUpload('curp_file', 'curp_file'),

                        TextInput::make('social_security_number'),
                        self::createFileUpload('social_security_file', 'social_security_file'),

                        TextInput::make('voter_id'),
                        self::createFileUpload('voter_id_file', 'voter_id_file'),

                    ])
                ,
            ]);
    }

    public static function createFileUpload(string $fieldName, string $documentType)
    {
        return FileUpload::make($fieldName)
            ->label('File')
            ->directory(fn() => 'employees/' . auth()->id() . '/documents')
            ->resize(50)
            ->optimize('webp')
            ->storeFileNamesIn('original_file_name')
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, Get $get) use ($documentType) {
                $extension = $file->getMimeType() === 'application/pdf' ? 'pdf' : 'webp';

                $fileName = auth()->user()->name . '_' . $documentType . '.' . $extension;
                $filePath = 'employees/' . auth()->id() . '/documents/' . $fileName;

                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                return $fileName;
            });
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('personal_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('organism')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tax_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expiration')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('other')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_driver_license')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_insurance')
                    ->boolean(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        $employeeId = auth()->user()->id;
        $employeePersonalInformation = Document::where('employee_id', $employeeId);
        return $employeePersonalInformation->count() === 0;
    }

    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $employeePersonalInformation = Document::where('employee_id', $employeeId);
        return $employeePersonalInformation;
    }
}
