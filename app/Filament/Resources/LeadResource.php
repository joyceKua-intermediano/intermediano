<?php

namespace App\Filament\Resources;

use App\Enums\LeadStatusEnum;
use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\ActionGroup;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('Sales');
    }

    public static function getModelLabel(): string
    {
        return __('Lead');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Pipeline');
    }

    public static function getNavigationLabel(): string
    {
        return __('Pipeline');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    Forms\Components\TextInput::make('lead')->label(__('Opportunity name'))
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('lead_status')->required()->live()
                    ->label(__('Lead Status'))->options(Lead::LEAD_STATUS),

                    Forms\Components\Textarea::make('close_reason')->label(__('Close Reason'))
                        ->hidden(function (Get $get) {
                            return !in_array($get('lead_status'), Lead::LEAD_STATUS_WITH_REASON);
                        })
                        ->requiredIf('lead_status', Lead::LEAD_STATUS_WITH_REASON)->columnSpanFull(),

                    Forms\Components\TextInput::make('country')->label(__('Country'))->maxLength(255),

                    Forms\Components\Select::make('lead_source')->label(__('Lead source'))
                        ->options([
                            'Self-Generated' => 'Self-Generated',
                            'Referral' => 'Referral'
                        ]),

                    Forms\Components\Select::make('opportunity_type')->label(__('Opportunity type'))
                        ->options(Lead::OPPORTUNITY_TYPES),

                    Forms\Components\TextInput::make('number_of_contractors')->label(__('Number Of Contractors'))
                        ->numeric(),

                    Forms\Components\Toggle::make('a2t')->label(__('A2T')),

                    Forms\Components\TextInput::make('estimated_tender_value')->label(__('Estimated Tender Value'))
                    ->numeric()
                    ->rules(['max:100000000']),

                    Forms\Components\DatePicker::make('estimated_close_date')->label(__('Close Date')),

                    Forms\Components\DatePicker::make('created_at')->label(__('Created Date')),

                    Forms\Components\Select::make('company_id')->label(__('Company'))
                        ->relationship('company', 'name')
                        ->searchable()->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('contact_id', '');
                        })
                        ->createOptionForm([
                            // company form
                            Section::make()->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()->label(__("Company Name"))
                                    ->maxLength(255),
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
                                Forms\Components\TextInput::make('field_of_industry')
                                    ->maxLength(255)->label(__("Field of industry")),
                                Forms\Components\TextInput::make('number_of_employees')->label(__("Number of employees"))->numeric(),
                                Toggle::make("is_customer")->columnSpanFull()->label(__("Customer")),
                                Repeater::make("contacts")->label(__('Contact Information'))->relationship()->schema([
                                    Section::make()->schema([
                                        Forms\Components\TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name")),
                                        Forms\Components\TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                                        Forms\Components\TextInput::make('email')->maxLength(255)->label(__("Email")),
                                        Forms\Components\TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                                        Forms\Components\TextInput::make('mobile')->maxLength(255)->label(__("Mobile")),
                                        Forms\Components\TextInput::make('phone')->maxLength(255)->label(__("Phone")),
                                        Forms\Components\TextInput::make('position')->maxLength(255)->label(__("Position")),
                                        Forms\Components\TextInput::make('department')->maxLength(255)->label(__("Department")),
                                        Forms\Components\Toggle::make('is_main_contact')->required()->label(__("Main Contact")),
                                    ])->columns(4)
                                ])->columnSpanFull()
                            ])->columns(3)
                        ])->createOptionModalHeading(__("Company Registration")),

                    Forms\Components\Select::make('contact_id')->label(__('Lead Contact'))
                        // ->relationship('contact', 'contact_name')
                        ->options(function (Get $get, Set $set) {
                            $contacts = Contact::when($get('company_id'), function ($query) use ($get)  {
                                $query->where('company_id', $get('company_id'));
                            })->pluck("contact_name", "id");

                            return $contacts;
                        })
                        ->searchable()->preload()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            
                            if ($get("contact_id")) {
                                $contact = Contact::find($get("contact_id"));
                                if ($contact && $contact->company_id) {
                                    $set("company_id", $contact->company_id);
                                }
                            }
                        })
                        ->createOptionForm([
                            // contact form
                            Section::make()->schema([
                                Forms\Components\TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name")),
                                Forms\Components\TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                                Forms\Components\TextInput::make('email')->maxLength(255)->label(__("Email")),
                                Forms\Components\TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                                Forms\Components\TextInput::make('mobile')->maxLength(255)->label(__("Mobile")),
                                Forms\Components\TextInput::make('phone')->maxLength(255)->label(__("Phone")),
                                Forms\Components\TextInput::make('position')->maxLength(255)->label(__("Position")),
                                Forms\Components\TextInput::make('department')->maxLength(255)->label(__("Department")),
                                Forms\Components\Toggle::make('is_main_contact')->required()->label(__("Main Contact")),
                            ])->columns(4)
                        ])
                        ->createOptionUsing(function (Get $get, array $data): int {
                         
                            if ($get('company_id')) {
                                $data['company_id'] = $get('company_id');
                            }

                            return Contact::create($data)->getKey();
                        })
                        ->createOptionModalHeading(__("Contact Registration")),

                    Forms\Components\Select::make('opportunity_owner')->label(__('Lead Owner'))->relationship("owner", "name")
                        ->searchable()->preload(),                   

                    // Forms\Components\TextInput::make('contact_name')->label(__('Contact name'))
                    //     ->maxLength(255),

                    
                    
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->label(__("ID"))->sortable(),
                Tables\Columns\TextColumn::make('lead')->label(__('Opportunity name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')->toggleable(isToggledHiddenByDefault: false)->label(__('Country'))
                    ->searchable(),
                Tables\Columns\SelectColumn::make('opportunity_type')->label(__('Opportunity type'))->options(Lead::OPPORTUNITY_TYPES)->disabled()
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('a2t')->label(__('A2T'))
                    ->boolean(),

                TextColumn::make('contact.fullname')->label(__("Contact Name")),

                Tables\Columns\TextColumn::make('lead_source')->label(__('Lead Source'))
                    ->searchable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\SelectColumn::make('lead_status')->label(__('Lead Status')
                )->options(Lead::LEAD_STATUS)->disabled()
                    ->searchable(),

                Tables\Columns\TextColumn::make('number_of_contractors')->label(__('Number Of Contractors'))
                    ->numeric()
                    ->sortable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('estimated_tender_value')->label(__('ETV'))
                    ->numeric()
                    ->sortable()->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('estimated_close_date')->label(__('Close Date'))
                    ->date("d/m/Y")->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label(__('Created date'))
                    ->date("d/m/Y")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                Tables\Columns\TextColumn::make('owner.name')->label(__('Lead Owner'))
                    ->sortable(),

                // Tables\Columns\TextColumn::make('company.name')->toggleable(isToggledHiddenByDefault: false)->label(__('Company'))
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('lead')->toggleable(isToggledHiddenByDefault: false)->label(__('Lead'))
                //     ->searchable(),
               
                // Tables\Columns\TextColumn::make('created_at')->label(__('Created at'))
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->label(__('Deleted at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    TableAction::make(__('Closed - Won'))
                        ->requiresConfirmation()
                        ->action(function (Lead $record) {
                            $record->lead_status = LeadStatusEnum::ClosedWon->value;
                            $record->close_reason = NULL;
                            $record->save();
                        })->color('success'),
                    TableAction::make(__('Closed - Cancelled'))
                        ->form([
                            Forms\Components\Textarea::make('close_reason')->label(__('Close Reason'))->required(),
                        ])->fillForm(function (Lead $record) {
                            return $record->toArray();
                        })
                        ->action(function (Lead $record, array $data) {
                            $record->close_reason = $data['close_reason'];
                            $record->lead_status = LeadStatusEnum::ClosedCancelled->value;
                            $record->save();
                        }),
                    TableAction::make(__('Closed - Lost'))
                        ->form([
                            Forms\Components\Textarea::make('close_reason')->label(__('Close Reason'))->required(),
                        ])->fillForm(function (Lead $record) {
                            return $record->toArray();
                        })
                        ->action(function (Lead $record, array $data) {
                            $record->close_reason = $data['close_reason'];
                            $record->lead_status = LeadStatusEnum::ClosedLost->value;
                            $record->save();
                        }),
                ]),
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }

    public static function getActions(): array
    {
        return [
            Action::make('customSave')
                ->label('Custom Save')
                ->action('saveCustom')
                ->color('primary'),
        ];
    }

    public static function saveCustom(array $data): void
    {
        // Your custom save logic
        // $model = new YourModel();
        // $model->fill($data);
        // $model->save();

        // Optionally, add a notification or redirect
    }
}
