<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Exports\PartnerPayrollExport;
use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource\RelationManagers;
use App\Models\MspPayroll;
use App\Models\Consultant;
use App\Models\Country;
use DateTime;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Maatwebsite\Excel\Facades\Excel;

class MspPayrollResource extends Resource
{
    protected static ?string $model = MspPayroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'MSP/Caribbean Payroll';

    protected static ?string $cluster = IntermedianoUruguay::class;
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $firstRecord = MspPayroll::first();

        return $form
            ->schema([
                DatePicker::make('title')
                    ->label('Date')
                    ->displayFormat('Y-m-d')
                    ->placeholder('yy-mm-dd')
                    ->native(false)
                    ->required(),
                Select::make('companies')
                    ->label('Customers')
                    ->multiple()
                    ->preload()
                    ->relationship('companies', 'name')
                    ->default($firstRecord?->companies?->pluck('id')->toArray())
                    ->required(),
                TextInput::make('bank_fee')
                    ->label('Banking Fee')
                    ->required()
                    ->numeric()
                    ->default($firstRecord?->bank_fee),
                TextInput::make('fee')
                    ->label('Fee')
                    ->required()
                    ->default($firstRecord?->fee)
                    ->numeric(),
                Repeater::make('data')
                    ->schema([
                        Select::make('consultant_id')
                            ->label('Consultant')
                            ->options(Consultant::pluck('name', 'id')->toArray())
                            ->required(),
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::pluck('name', 'id')->toArray())
                            ->required(),
                        TextInput::make('monthly_salary')
                            ->label('Monthly Salary')
                            ->numeric()
                            ->required(),
                        TextInput::make('overtime')
                            ->label('Overtime')
                            ->numeric(),
                        TextInput::make('other')
                            ->label('Other')
                            ->numeric(),

                        TextInput::make('other_expenses')
                            ->label('Other Expense (Banking Fee, Reimbursement)')
                            ->numeric(),
                    ])
                    ->itemLabel(function (array $state): ?HtmlString {
                        $consultant = Consultant::where('id', $state['consultant_id'])->value('name');
                        $monthSalary = $state['monthly_salary'];
                        return new HtmlString(
                            "<span>
                                <span style='font-weight: bold;'>{$consultant} - </span>
                                <span style='font-weight: bold;'>Monthly Salary: {$monthSalary}</span>
                
                            </span>"
                        );
                    })
                    ->default($firstRecord->data ?? null)
                    ->orderable('order')
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()

                    ->columns(1)
                    ->grid(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('companies.name')
                    ->label('Companies')
                    ->colors(['primary']),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ExportAction::make('export')
                    ->label('Export Payrolls')
                    ->action(function ($record) {
                        $export = new PartnerPayrollExport($record);
                        $dateString = $record->title;
                        $date = new DateTime($dateString);
                        $dateFormat = $date->format('F_Y');
                        $fileName = $date->format('y.m') . '_Wesco_Anixter_Payroll Caribbean Islands_' . $dateFormat;
                        return Excel::download($export, $fileName . '.xlsx');
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMspPayrolls::route('/'),
            'create' => Pages\CreateMspPayroll::route('/create'),
            'edit' => Pages\EditMspPayroll::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
