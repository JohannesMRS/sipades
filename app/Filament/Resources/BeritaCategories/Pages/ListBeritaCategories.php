<?php

namespace App\Filament\Resources\BeritaCategories\Pages;

use App\Filament\Resources\BeritaCategories\BeritaCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBeritaCategories extends ListRecords
{
    protected static string $resource = BeritaCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
