<?php

namespace App\Filament\Resources\Pembangunans\Pages;

use App\Filament\Resources\Pembangunans\PembangunanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPembangunans extends ListRecords
{
    protected static string $resource = PembangunanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
