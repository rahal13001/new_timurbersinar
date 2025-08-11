<?php

namespace App\Filament\PelayananJenis\Resources\SipjiResource\Pages;

use App\Filament\PelayananJenis\Resources\SipjiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSipjis extends ManageRecords
{
    protected static string $resource = SipjiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
