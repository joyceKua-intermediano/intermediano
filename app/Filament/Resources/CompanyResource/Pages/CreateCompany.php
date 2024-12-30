<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            // ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            // Action::make("create-and-create-company")->label(__("Save and go to company registration"))->action("saveAndCreateCompany"),
            $this->getCancelFormAction(),
        ];
    }

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable {
        return __("Company Registration");
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
