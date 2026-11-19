<?php

namespace App\Filament\Resources\BeritaCategories\Pages;

use App\Filament\Resources\BeritaCategories\BeritaCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBeritaCategory extends EditRecord
{
    protected static string $resource = BeritaCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
