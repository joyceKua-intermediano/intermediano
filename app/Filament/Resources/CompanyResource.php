<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\CompanyResource\RelationManagers\ContactsRelationManager;
use App\Models\Company;
use App\Models\Contact;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('Sales');
    }

    public static function getModelLabel(): string
    {
        return __('Company');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Company Directory');
    }

    public static function getNavigationLabel(): string
    {
        return __('Company Directory');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()->label(__("Company Name"))
                        ->maxLength(255)->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                            return $rule->whereNull('deleted_at');
                        }),
                    Forms\Components\TextInput::make('website')
                        ->maxLength(255)->label(__("Website")),
                    Forms\Components\TextInput::make('tax_id')
                        ->maxLength(255)->label(__("Tax ID")),
                    Forms\Components\TextInput::make('country')
                        ->maxLength(255)->label(__("Country")),
                    Forms\Components\TextInput::make('state')
                        ->maxLength(255)->label(__("State")),
                    Forms\Components\TextInput::make('city')
                        ->maxLength(255)->label(__("City")),
                    Forms\Components\TextInput::make('postal_code')
                        ->maxLength(255)->label(__("Postal Code")),
                    Forms\Components\TextInput::make('address')
                        ->maxLength(255)->label(__("Address")),
                    Forms\Components\Select::make('industry_field_id')->label(__("Field of industry"))
                    ->relationship('industry_field', 'name')
                    ->preload()->searchable()
                    ->createOptionForm([
                        // company form
                        Section::make()->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()->label(__("Name"))
                                ->maxLength(255),
                        ])->columns(3)
                    ])->createOptionModalHeading(__("Filed of Industry Registration")),
                    Forms\Components\TextInput::make('number_of_employees')->label(__("Number of employees"))->numeric(),
                    Toggle::make("is_customer")->label(__("Customer")),
                    Repeater::make("contacts")->label(__('Contact Information'))->relationship()->schema([
                        Section::make()->schema([
                            Forms\Components\TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name"))->reactive(),
                            Forms\Components\TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                            Forms\Components\TextInput::make('email')->maxLength(255)->label(__("Email")),
                            Forms\Components\TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                            Forms\Components\TextInput::make('mobile')->maxLength(255)->label(__("Mobile")),
                            Forms\Components\TextInput::make('phone')->maxLength(255)->label(__("Phone")),
                            Forms\Components\TextInput::make('position')->maxLength(255)->label(__("Job Title")),
                            Forms\Components\TextInput::make('department')->maxLength(255)->label(__("Department")),
                            Forms\Components\Toggle::make('is_main_contact')->required()->label(__("Main Contact")),

                        ])->columns(4)
                    ])->columnSpanFull()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__("Company Name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')->label(__("Country"))
                    ->searchable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('industry_field.name')->label(__("Field of industry"))->toggleable(isToggledHiddenByDefault: false),
               
                Tables\Columns\TextColumn::make('website')->label(__("Website"))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'contact_fullname')->label(__("Contact")),
                Tables\Columns\TextColumn::make(name: 'main_contact.position')->label(__("Job Title")),
                Tables\Columns\TextColumn::make(name: 'main_contact.email')->label(__("Email")),
                Tables\Columns\TextColumn::make(name: 'main_contact.mobile')->label(__("Mobile")),
                // Tables\Columns\TextColumn::make(name: 'main_contact.whatsapp')->label(__("Whatsapp")),

                // Tables\Columns\TextColumn::make('address')->label(__("Address"))->searchable(),

                Tables\Columns\TextColumn::make('tax_id')->label(__("Tax"))
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('state')->label(__("State"))
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')->label(__("City"))
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('postal_code')->label(__("Postal Code"))
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                
                
                Tables\Columns\TextColumn::make('number_of_employees')->label(__("Number of employees"))
                    ->numeric()->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__("Updated at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->label(__("Deleted at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
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
            // ContactsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
