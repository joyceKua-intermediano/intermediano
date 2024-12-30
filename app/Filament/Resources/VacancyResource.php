<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Models\Contact;
use App\Models\Vacancy;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Recruitment');
    }

    public static function getModelLabel(): string
    {
        return __('Job');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Job Opening');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Requester")->schema([
                    Forms\Components\Select::make('company_id')
                        ->relationship('company', 'name')
                        ->preload()->searchable()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('contact_id', '');
                        })
                        ->label('Client'),
                    Forms\Components\Select::make('contact_id')
                        ->options(function (Get $get) {
                            return Contact::when($get('company_id'), function ($query) use ($get) {
                                $query->whereCompanyId($get('company_id'));
                            })->pluck('contact_name', 'id');
                        })
                        ->preload()->searchable()
                        ->label('Contact'),
                ])->columns(2),
                Section::make("Job Details")->schema([
                    Forms\Components\TextInput::make('job_title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('number_of_openings')
                        ->required()
                        ->numeric(),
                    Forms\Components\Select::make('work_type')
                        ->options([
                            "On-Site" => "On-Site",
                            "Hybrid" => "Hybrid",
                            "Home Office" => "Home Office"
                        ]),
                    Forms\Components\TextInput::make('location')->label('Country/City')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('salary'),

                    Forms\Components\Select::make('contract_model')
                        ->options([
                            "Indefinite Period" => "Indefinite Period",
                            "Temporary Contract" => "Temporary Contract"
                        ]),

                    TextInput::make('work_schedule'),

                    Forms\Components\DatePicker::make('target_start_date'),

                    Repeater::make('allowances')->relationship('allowances')
                        ->label('Allowances')->schema([
                            TextInput::make('name')
                        ])->columnSpanFull(),

                    Repeater::make('skills')->relationship('skills')
                    ->label('Skills/Certificates')->schema([
                        Section::make()->schema([
                            TextInput::make('name'),
                            Toggle::make('mandatory')->label('Mandatory')
                        ])->columns(2)
                    ])->columnSpanFull(),

                    Repeater::make('languages')->relationship('languages')
                    ->label('Languages')->schema([
                        Section::make()->schema([
                            TextInput::make('name'),
                            Toggle::make('mandatory')->label('Mandatory')
                        ])->columns(2)
                    ])->columnSpanFull(),

                    
                ])->columns(4),
                Section::make("Resume")->schema([
                    Forms\Components\Textarea::make('summary')
                        ->columnSpanFull(),

                    Forms\Components\Select::make('english_level')
                        ->options([
                            "Basic" => "Basic",
                            "Intermediate" => "Intermediate",
                            "Fluent" => "Fluent",
                            "Native" => "Native"
                        ])->label('English Level'),

                    Forms\Components\TextInput::make('profile'),

                    Forms\Components\Select::make('education')
                    ->options([
                        "High School" => "High School",
                        "College Degree" => "College Degree",
                        "MBA/Especialization" => "MBA/Especialization",
                        "Master" => "Master",
                        "PhD" => "PhD"
                    ])->label('Education Level'),

                    Forms\Components\Textarea::make('other_info')
                        ->columnSpanFull()->label('Trainings/Others'),

                    Forms\Components\Select::make('status')
                        ->required()
                        ->options([
                            "Open" => "Open", 
                            "In Progress" => "In Progress", 
                            "Waiting" => "Waiting", 
                            "Cancelled" => "Cancelled", 
                            "Finalized" => "Finalized"
                        ])
                        ->default('Open')
                ])->columns(3),

                Actions::make([
                    Action::make('publish_on_website')->label('Post Vacancy on Website')->action(function (Vacancy $vacancy) {
                        $vacancy->published_on_website = true;
                        $vacancy->save();
                    })->requiresConfirmation()->hidden(function (Vacancy $vacancy) {
                        return $vacancy->published_on_website;
                    }),
                    Action::make('remove_on_website')->label('Remove Vacancy on Website')->action(function (Vacancy $vacancy) {
                        $vacancy->published_on_website = false;
                        $vacancy->save();
                    })->requiresConfirmation()->hidden(function (Vacancy $vacancy) {
                        return !$vacancy->published_on_website;
                    })->color('danger')
                ])->hiddenOn('create')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('#ID'),

                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_openings')
                    ->numeric()->label('Number of Openings')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->searchable()->label('Vacancy Status'),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('Client')
                    ->sortable(),

                Tables\Columns\TextColumn::make('target_start_date')
                    ->date("d/m/Y")
                    ->sortable()->label('Start date'),

                // Tables\Columns\TextColumn::make('contact.fullname')
                //     ->numeric()
                //     ->sortable(),
                
                // Tables\Columns\TextColumn::make('work_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('location')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('salary')
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('contract_model')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('target_start_date')
                //     ->date()->toggleable(isToggledHiddenByDefault: true)
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('education')
                //     ->searchable()->toggleable(isToggledHiddenByDefault: true),
               
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
