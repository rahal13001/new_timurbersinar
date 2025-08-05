<?php

namespace App\Filament\Resources\PermittypeResource\Pages;

use App\Filament\Resources\PermittypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePermittypes extends ManageRecords
{
    protected static string $resource = PermittypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
