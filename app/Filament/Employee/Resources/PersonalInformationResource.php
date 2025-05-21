<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\PersonalInformationResource\Pages;
use App\Filament\Employee\Resources\PersonalInformationResource\RelationManagers;
use App\Models\PersonalInformation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;

class PersonalInformationResource extends Resource
{
    protected static ?string $model = PersonalInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->disabled()
                    ->relationship('employee', 'name')
                    ->default(auth()->user()->id)
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('gender')
                            ->label('Enter a new gender if not listed')
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        return $data['gender'];
                    })
                    ->required()
                    ->default(''),
                Forms\Components\Select::make('civil_status')
                    ->label('Civil Status')
                    ->options([
                        'Single' => 'Single',
                        'Married' => 'Married',
                        'Widow' => 'Widow',
                    ])
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('civil_status')
                            ->label('New Civil Status')
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        // Return the newly created value
                        return $data['civil_status'];
                    })
                    ->required()
                    ->default('Single'),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('nationality')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('postal_code')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('mobile')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('education_attainment')
                    ->options([
                        'High school' => 'High School',
                        'College' => 'College',
                        'MBA' => 'MBA',
                        'Doctorate' => 'Doctorate',
                    ])
                    ->required(),
                Forms\Components\Select::make('education_status')
                    ->options([
                        'complete' => 'Complete',
                        'incomplete' => 'Incomplete',
                    ])
                    ->required(),
                Forms\Components\Select::make('is_local')
                    ->label('Expat')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('passport_number')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('work_visa')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('number_of_dependents')
                    ->numeric()
                    ->default(0),

                Forms\Components\Repeater::make('dependents')
                    ->relationship('dependents')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        Forms\Components\TextInput::make('full_name')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('relationship')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->default(null),
                        Forms\Components\TextInput::make('tax_id')
                            ->maxLength(255)
                            ->default(null),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
                    ->label('Dependents'),
                Forms\Components\Fieldset::make('Emergency Contact')
                    ->relationship('emergencyContact')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        TextInput::make('emergency_contact_name')
                            ->label('Contact Person in case of emergency')
                            ->required()
                            ->placeholder('Enter full name'),
                        TextInput::make(name: 'relationship')
                            ->label('Relationship')
                            ->required()
                            ->placeholder('Enter mobile number'),
                        TextInput::make('mobile_number')
                            ->label('mobile number')
                            ->required()
                            ->placeholder('Enter mobile number'),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->placeholder('Enter email'),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_local')
                    ->boolean(),
                Tables\Columns\TextColumn::make('work_visa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nationality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_attainment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_status')
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
            'index' => Pages\ListPersonalInformation::route('/'),
            'create' => Pages\CreatePersonalInformation::route('/create'),
            'edit' => Pages\EditPersonalInformation::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {

        $employeeId = auth()->user()->id;
        $employeePersonalInformation = PersonalInformation::where('employee_id', $employeeId);
        return $employeePersonalInformation->count() === 0;
    }

    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $employeePersonalInformation = PersonalInformation::where('employee_id', $employeeId);
        return $employeePersonalInformation;
    }
}
