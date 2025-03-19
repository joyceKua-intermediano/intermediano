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
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('expiration'),
                Forms\Components\TextInput::make('other')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_driver_license')
                    ->inline(false)
                    ->required(),
                Forms\Components\Toggle::make('has_insurance')
                    ->inline(false)
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255)
                    ->default(null),

                Repeater::make('documents')
                    ->relationship('bankingDetails')
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
                            ->directory('employees/documents')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                            ->maxSize(2048)
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
                    ->orderable('id')
                    ->defaultItems(0),

                Repeater::make('socialSecurityInfos')
                    ->relationship('socialSecurityInfos')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        TextInput::make('health_fund')->required(),
                        TextInput::make('pension_fund')->required(),
                        TextInput::make('severance_fund')->required(),

                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
                    ->orderable('id')
                    ->defaultItems(0),
            ]);
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
}
