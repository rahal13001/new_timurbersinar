<?php

namespace App\Filament\PelayananJenis\Resources\UptResource\Pages;

use App\Filament\PelayananJenis\Resources\UptResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUpts extends ManageRecords
{
    protected static string $resource = UptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
