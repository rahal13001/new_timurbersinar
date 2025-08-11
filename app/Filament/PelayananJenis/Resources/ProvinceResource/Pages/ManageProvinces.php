<?php

namespace App\Filament\PelayananJenis\Resources\ProvinceResource\Pages;

use App\Filament\PelayananJenis\Resources\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvinces extends ManageRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
