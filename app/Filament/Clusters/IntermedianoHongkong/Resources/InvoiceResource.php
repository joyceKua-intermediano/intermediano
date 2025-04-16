<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources;

use App\Filament\Clusters\IntermedianoHongkong;
use App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource\Pages;
use App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Support\RawJs;

class InvoiceResource extends Resource
{
    protected static ?int $navigationSort = 1;

    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoHongkong::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2) // Adjust the grid columns as needed
                    ->schema([
                        Forms\Components\Select::make('employee_id')
                            ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoHongkong'))
                            ->required(),
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'name')
                            ->required(),
                        DatePicker::make('invoice_date')
                            ->label('Date')
                            ->displayFormat('Y-m-d')
                            ->placeholder('yy-mm-dd')
                            ->native(false)
                            ->required(),
                        Forms\Components\Hidden::make('cluster_name')
                            ->default(self::getClusterName())
                            ->label(self::getClusterName()),
                    ]), // Closing schema for the grid
                Repeater::make('invoice_items')
                    ->schema([
                        TextInput::make('description')->required(),
                        TextInput::make('quantity')->required(),
                        Forms\Components\TextInput::make('unit_price')
                            ->mask(RawJs::make(<<<'JS'
                            $money($input, '.', ',', 2)
                        JS))
                            ->afterStateUpdated(function ($component, $state) {
                                $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                                $component->state($cleanedState);
                            })
                            ->required(),
                        TextInput::make('tax')->required(),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Invoice ID')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => str_pad($state, 4, '0', STR_PAD_LEFT)),

                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('Invoice Date')
                    ->sortable()
                    ->date(),



                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),


            ])
            ->filters([
                Tables\Filters\Filter::make('recent')
                    ->label('Recent Invoices')
                    ->query(fn(Builder $query) => $query->whereDate('created_at', '>=', now()->subMonth())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('Generate Invoice')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPage = 'pdf.invoices.hong_kong';
                        $invoiceId = 'INV-000' . $record->id;
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            'Invoice ' . $invoiceId . '.pdf'
                        );
                    }),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
