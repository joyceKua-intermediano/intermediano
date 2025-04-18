<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources;

use App\Exports\InvoicesExport;
use App\Filament\Clusters\IntermedianoHongkong;
use App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource\Pages;
use App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Support\RawJs;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
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
                            ->searchable()
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
                Filter::make('Month')
                    ->form([
                        DatePicker::make('month')
                            ->displayFormat('Y-m')
                            ->placeholder('Select Month')
                            ->extraInputAttributes(['type' => 'month'])

                            ->native(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['month']) {
                            $query->whereMonth('invoice_date', Carbon::parse($data['month'])->month);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            ->headerActions([
                Action::make('ExportByMonth')
                    ->label('Export Invoices by Month')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Month')
                            ->options([
                                '1' => 'January',
                                '2' => 'February',
                                '3' => 'March',
                                '4' => 'April',
                                '5' => 'May',
                                '6' => 'June',
                                '7' => 'July',
                                '8' => 'August',
                                '9' => 'September',
                                '10' => 'October',
                                '11' => 'November',
                                '12' => 'December',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('year')
                            ->label('Year')
                            ->numeric()
                            ->default(date('Y'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        return self::exportInvoices($data['month'], $data['year']);
                    })
                    ->requiresConfirmation(),
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

    public static function exportInvoices($month, $year)
    {
        $currentMonthInvoices = Invoice::whereMonth('invoice_date', $month)
            ->whereYear('invoice_date', $year)
            ->with(['employee', 'company'])
            ->get();
        
        $previousInvoices = Invoice::whereMonth('invoice_date', '<', $month)
            ->whereYear('invoice_date', $year)
            ->get();
            if ($currentMonthInvoices->isEmpty()) {
                Notification::make()
                    ->title('No invoices found')
                    ->body('No invoices found for the selected month and year.')
                    ->danger()
                    ->send();
                
                return redirect()->back();
            }

        $fileName = "invoices_{$year}_{$month}.xlsx";

        Excel::store(new InvoicesExport($currentMonthInvoices, $previousInvoices), $fileName, 'local');

        return response()->download(Storage::path($fileName))->deleteFileAfterSend();
    }
}
