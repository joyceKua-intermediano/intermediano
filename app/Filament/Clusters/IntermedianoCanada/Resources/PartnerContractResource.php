<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources;

use App\Filament\Clusters\IntermedianoCanada;
use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource\Pages;
use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource\RelationManagers;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;
class PartnerContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Partner Contract';

    protected static ?int $navigationSort = 8;
    protected static ?string $cluster = IntermedianoCanada::class;

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
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoCanada'))
                    ->required(),
                Forms\Components\Select::make('quotation_id')
                    ->relationship(
                        'quotation',
                        'title',
                        fn(Builder $query) => $query->where('cluster_name', 'PartnerCanada')->where('is_payroll', '0')
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
                    ->default('PartnerCanada')
                    ->label('PartnerCanada'),
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
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        Forms\Components\Select::make('contractType')
                            ->label('Contract Type')
                            ->options([
                                'partner_english' => '(English)',
                                'english_portuguese' => '(English - Portuguese)',
                                'english_spanish' => '(English - Spanish)',
                                'english_french' => '(English - French)',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $pdfPageMapping = [
                            'english_portuguese' => 'pdf.contract.canada.partner.english_portuguese',
                            'partner_english' => 'pdf.contract.canada.partner.english',
                            'english_spanish' => 'pdf.contract.canada.partner.english_spanish',
                            'english_french' => 'pdf.contract.canada.partner.english_french',
                        ];

                        $pdfPage = $pdfPageMapping[$data['contractType']] ?? null;
                        if (!$pdfPage) {
                            throw new \Exception('Invalid contract type selected.');
                        }

                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('es');
                        $record->translatedPosition = $tr->translate($record->companyContact->position ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contract with_' . $record->partner->partner_name . '_of employee';
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record, 'poNumber' => $contractTitle, 'company' => 'Gate Intermediano Inc.', 'is_pdf' => true]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            $fileName . '.pdf'
                        );
                    })
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
            'index' => Pages\ListPartnerContracts::route('/'),
            'create' => Pages\CreatePartnerContract::route('/create'),
            'edit' => Pages\EditPartnerContract::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $contractCluster = Contract::where('cluster_name', 'PartnerCanada')->where('contract_type', 'partner');
        return $contractCluster;
    }
}
