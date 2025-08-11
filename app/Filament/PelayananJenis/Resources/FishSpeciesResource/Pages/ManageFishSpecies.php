<?php

namespace App\Filament\PelayananJenis\Resources\FishSpeciesResource\Pages;

use App\Filament\PelayananJenis\Resources\FishSpeciesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFishSpecies extends ManageRecords
{
    protected static string $resource = FishSpeciesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
