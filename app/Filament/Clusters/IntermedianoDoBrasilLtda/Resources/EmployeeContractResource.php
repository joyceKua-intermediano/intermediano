<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources;

use App\Filament\Clusters\IntermedianoDoBrasilLtda;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeContractResource\Pages;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeContractResource\RelationManagers;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;
use Stichoza\GoogleTranslate\GoogleTranslate;

class EmployeeContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Employee Contract';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoDoBrasilLtda::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('contract_type')
                    ->default('employee'),
                Forms\Components\Select::make('company_id')
                    ->label('Customer')
                    ->relationship('company', 'name', fn(Builder $query) => $query->where('is_customer', true))
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: 'name')
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
                    ->maxLength(255)
                    ->default(null),
                RichEditor::make('job_description')->columnSpanFull(),
                RichEditor::make('translated_job_description')->columnSpanFull(),
                Forms\Components\Hidden::make('cluster_name')
                    ->default(self::getClusterName())
                    ->label(self::getClusterName()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
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
                Filter::make('cluster_match')
                    ->label('Company Name')
                    ->query(fn(Builder $query): Builder => $query->where('cluster_name', self::getClusterName()))
                    ->default(),
                SelectFilter::make('contract_type')
                    ->options([
                        'customer' => 'Customer',
                        'employee' => 'Employee',
                    ])
                    ->default('employee'),

                SelectFilter::make('end_date')
                    ->label('Contract Period')
                    ->options([
                        'defined' => 'Defined Period Contract',
                        'undefined' => 'Undefined Period Contract',
                        'both' => 'Both', // Option to show all records
                    ])
                    ->query(function (Builder $query, $state) { // $state will now be a string or null
                        switch ($state['value']) {
                            case 'defined':
                                return $query->whereNot('end_date', null); // Defined period contracts
                            case 'undefined':
                                return $query->where('end_date', null); // Undefined period contracts
                            case 'both':
                            default:
                                return $query;
                        }
                    })
                    ->default('both'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPage = $record->end_date == null ? 'pdf.contract.brazil.undefined_employee' : 'pdf.contract.brazil.defined_employee';
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('en');
                        $record->translatedPosition = $tr->translate($record->job_title ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contrato Individual de ' . $record->employee->name . '_of employee';

                        $pdf = Pdf::loadView($pdfPage, [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'company' => 'Intermediano do Brasil Ltda.',
                        ]);

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeContracts::route('/'),
            'create' => Pages\CreateEmployeeContract::route('/create'),
            'edit' => Pages\EditEmployeeContract::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
