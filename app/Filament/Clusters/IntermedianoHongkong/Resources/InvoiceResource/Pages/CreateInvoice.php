<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
