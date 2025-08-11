<?php

namespace App\Filament\PelayananJenis\Resources\QuotaSourceResource\Pages;

use App\Filament\PelayananJenis\Resources\QuotaSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuotaSources extends ManageRecords
{
    protected static string $resource = QuotaSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
