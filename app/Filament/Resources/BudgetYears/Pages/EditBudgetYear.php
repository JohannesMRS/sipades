<?php

namespace App\Filament\Resources\BudgetYears\Pages;

use App\Filament\Resources\BudgetYears\BudgetYearResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBudgetYear extends EditRecord
{
    protected static string $resource = BudgetYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
