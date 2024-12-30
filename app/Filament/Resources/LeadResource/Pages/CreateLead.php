<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Facades\FilamentView;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            // ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            // Action::make("create-and-create-company")->label(__("Save and go to company registration"))->action("saveAndCreateCompany"),
            $this->getCancelFormAction(),
        ];
    }

    public function saveAndCreateCompany() {
        // save new lead

        $this->beginDatabaseTransaction();

        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeCreate($data);

        $this->callHook('beforeCreate');

        $this->record = $this->handleRecordCreation($data);

        $this->form->model($this->getRecord())->saveRelationships();

        $this->callHook('afterCreate');

        $this->commitDatabaseTransaction();

        $this->rememberData();
        // $this->getCreatedNotification()?->send();

        session(['leadId' => $this->record?->id]);

        Notification::make()
            ->title(__("The lead was created sucessfull. Now add the company information"))
            ->success()
            ->send();

        $this->redirect('/admin/companies/create', navigate: FilamentView::hasSpaMode());
    }

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable {
        return __("Lead Registration");
    }
}
