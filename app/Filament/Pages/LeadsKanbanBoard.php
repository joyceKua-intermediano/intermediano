<?php

namespace App\Filament\Pages;

use App\Enums\LeadStatusEnum;
use App\Enums\LeadStatusKanbanEnum;
use App\Models\Contact;
use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use UnitEnum;

class LeadsKanbanBoard extends KanbanBoard
{
    protected static string $model = Lead::class;
    protected static string $statusEnum = LeadStatusKanbanEnum::class;

    protected static string $recordTitleAttribute = 'title';
    protected static string $recordStatusAttribute = 'lead_status';

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('Lead Status Kanban');
    }


    public function getTitle(): string | Htmlable
    {
        return __('Lead Status Kanban');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Sales');
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            // TextInput::make('lead'),
            Section::make()->schema([
                TextInput::make('lead')->label(__('Opportunity name'))
                    ->required()
                    ->maxLength(255),

                Select::make('lead_status')->required()->live()
                    ->label(__('Lead Status'))->options(Lead::LEAD_STATUS),

                Textarea::make('close_reason')->label(__('Close Reason'))
                    ->hidden(function (Get $get) {
                        return !in_array($get('lead_status'), Lead::LEAD_STATUS_WITH_REASON);
                    })
                    ->requiredIf('lead_status', Lead::LEAD_STATUS_WITH_REASON)->columnSpanFull(),

                TextInput::make('country')->label(__('Country'))->maxLength(255),

                Select::make('lead_source')->label(__('Lead source'))
                    ->options([
                        'Self-Generated' => 'Self-Generated',
                        'Referral' => 'Referral'
                    ]),

                Select::make('opportunity_type')->label(__('Opportunity type'))
                    ->options(Lead::OPPORTUNITY_TYPES),

                TextInput::make('number_of_contractors')->label(__('Number Of Contractors'))
                    ->numeric(),

                Toggle::make('a2t')->label(__('A2T')),

                TextInput::make('estimated_tender_value')->label(__('Estimated Tender Value'))
                    ->numeric(),

                DatePicker::make('estimated_close_date')->label(__('Close Date')),

                DatePicker::make('created_at')->label(__('Created Date')),

                Select::make('company_id')->label(__('Company'))
                    ->relationship('company', 'name')
                    ->searchable()->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('contact_id', '');
                    })
                    ->createOptionForm([
                        // company form
                        Section::make()->schema([
                            TextInput::make('name')
                                ->required()->label(__("Company Name"))
                                ->maxLength(255),
                            TextInput::make('website')
                                ->maxLength(255)->label(__("Website")),
                            TextInput::make('tax_id')
                                ->maxLength(255)->label(__("Tax ID")),
                            TextInput::make('country')
                                ->maxLength(255)->label(__("Country")),
                            TextInput::make('state')
                                ->maxLength(255)->label(__("State")),
                            TextInput::make('city')
                                ->maxLength(255)->label(__("City")),
                            TextInput::make('postal_code')
                                ->maxLength(255)->label(__("Postal Code")),
                            TextInput::make('address')
                                ->maxLength(255)->label(__("Address")),
                            TextInput::make('field_of_industry')
                                ->maxLength(255)->label(__("Field of industry")),
                            TextInput::make('number_of_employees')->label(__("Number of employees"))->numeric(),
                            Toggle::make("is_customer")->columnSpanFull()->label(__("Customer")),
                            Repeater::make("contacts")->label(__('Contact Information'))->relationship()->schema([
                                Section::make()->schema([
                                    TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name")),
                                    TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                                    TextInput::make('email')->maxLength(255)->label(__("Email")),
                                    TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                                    TextInput::make('mobile')->maxLength(255)->label(__("Mobile")),
                                    TextInput::make('phone')->maxLength(255)->label(__("Phone")),
                                    TextInput::make('position')->maxLength(255)->label(__("Position")),
                                    TextInput::make('department')->maxLength(255)->label(__("Department")),
                                    Toggle::make('is_main_contact')->required()->label(__("Main Contact")),
                                ])->columns(4)
                            ])->columnSpanFull()
                        ])->columns(3)
                    ])->createOptionModalHeading(__("Company Registration")),

                Select::make('contact_id')->label(__('Lead Contact'))
                    // ->relationship('contact', 'contact_name')
                    ->options(function (Get $get, Set $set) {
                        $contacts = Contact::when($get('company_id'), function ($query) use ($get) {
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
                            TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name")),
                            TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                            TextInput::make('email')->maxLength(255)->label(__("Email")),
                            TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                            TextInput::make('mobile')->maxLength(255)->label(__("Mobile")),
                            TextInput::make('phone')->maxLength(255)->label(__("Phone")),
                            TextInput::make('position')->maxLength(255)->label(__("Position")),
                            TextInput::make('department')->maxLength(255)->label(__("Department")),
                            Toggle::make('is_main_contact')->required()->label(__("Main Contact")),
                        ])->columns(4)
                    ])
                    ->createOptionUsing(function (Get $get, array $data): int {
                         
                        if ($get('company_id')) {
                            $data['company_id'] = $get('company_id');
                        }
                        
                        return Contact::create($data)->getKey();
                    })
                    ->createOptionModalHeading(__("Contact Registration")),

                Select::make('opportunity_owner')->label(__('Lead Owner'))->relationship("owner", "name")
                    ->searchable()->preload(),
            ])->columns(2)
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can("List Lead");
    }

    protected function filterRecordsByStatus(Collection $records, array $status): array
    {
        $statusIsCastToEnum = $records->first()?->getAttribute(static::$recordStatusAttribute) instanceof UnitEnum;

        $filter = $statusIsCastToEnum
            ? static::$statusEnum::from($status['id'])
            : $status['id'];

        // return $records->where(static::$recordStatusAttribute, 'LIKE', "%".$filter."%")->all();
        return $records->filter(function ($item) use ($filter) {
            $column = static::$recordStatusAttribute;
            return str_contains($item->$column, $filter);
        })->all();
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make(__("Pipeline"))
                ->icon('heroicon-o-presentation-chart-line')
                ->url(route('filament.admin.resources.leads.index')),
        ];
    }
}
