<?php

namespace App\Filament\PelayananJenis\Resources\DocumentTypeResource\Pages;

use App\Filament\PelayananJenis\Resources\DocumentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentTypes extends ManageRecords
{
    protected static string $resource = DocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
