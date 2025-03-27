<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\EmployeeContractResource\Pages;
use App\Filament\Employee\Resources\EmployeeContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EmployeeContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Contract';
    protected static ?string $pluralLabel = 'Contract';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ])

            ->actions([
                Tables\Actions\Action::make('view_contract')
                    ->label('View Contract')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
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

                        $viewModal = 'filament.quotations.brasil_modal';
                        return view($pdfPage, [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'company' => 'Intermediano do Brasil Ltda.',
                            'is_pdf' => false
                        ]);
                    }),
                Tables\Actions\Action::make('uploadSignature')
                    ->label('Upload Signature')
                    ->icon('heroicon-o-arrow-up-tray')

                    ->form([
                        Forms\Components\FileUpload::make('signature')
                            ->label('Signature File')
                            ->disk('public')
                            ->directory('signatures')
                            ->visibility('public')
                            ->optimize('webp')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->resize(50)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                $fileName = 'employee_' . auth()->user()->id . '.' . $file->getClientOriginalExtension();

                                $filePath = 'signatures/' . $fileName;
                                if (Storage::disk('public')->exists($filePath)) {
                                    Storage::disk('public')->delete($filePath);
                                }

                                return $fileName;
                            })
                            ->required(),
                        Forms\Components\Hidden::make('signed_contract')
                            ->default(now()->toDateTimeString()),
                    ])
                    ->action(function ($record, $data) {
                        $record->update([
                            'signature' => $data['signature'],
                            'signed_contract'  => $data['signed_contract'],
                        ]);
                    }),
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
                            'is_pdf' => true

                        ]);
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            $fileName . '.pdf'
                        );
                    }),

            ])
            ->searchable(false);
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
        $employeeId = auth()->user()->id;
        $getEmployeeExpenses = Contract::where('employee_id',  $employeeId)->where('is_sent_to_employee', true);
        return $getEmployeeExpenses;
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }
}
