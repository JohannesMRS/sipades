<?php

namespace App\Filament\Resources\BudgetYears\Pages;

use App\Filament\Resources\BudgetYears\BudgetYearResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBudgetYears extends ListRecords
{
    protected static string $resource = BudgetYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
