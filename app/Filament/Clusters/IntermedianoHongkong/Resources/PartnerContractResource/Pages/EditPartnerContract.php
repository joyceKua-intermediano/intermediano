<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerContract extends EditRecord
{
    protected static string $resource = PartnerContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!empty($data['partner_id'])) {
            $data['combined_select'] = 'partner_' . $data['partner_id'];
        } elseif (!empty($data['intermediano_company_id'])) {
            $data['combined_select'] = 'company_' . $data['intermediano_company_id'];
        }

        return $data;
    }
}
