<?php

namespace App\Filament\PelayananJenis\Resources\UnitResource\Pages;

use App\Filament\PelayananJenis\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnits extends ManageRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
