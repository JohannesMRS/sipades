<?php

namespace App\Filament\Resources\BudgetYears;

use App\Filament\Resources\BudgetYears\Pages\CreateBudgetYear;
use App\Filament\Resources\BudgetYears\Pages\EditBudgetYear;
use App\Filament\Resources\BudgetYears\Pages\ListBudgetYears;
use App\Filament\Resources\BudgetYears\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\BudgetYears\RelationManagers\FinancingRelationManager;
use App\Filament\Resources\BudgetYears\RelationManagers\IncomesRelationManager;
use App\Filament\Resources\BudgetYears\Schemas\BudgetYearForm;
use App\Filament\Resources\BudgetYears\Tables\BudgetYearsTable;
use App\Models\BudgetYear;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BudgetYearResource extends Resource
{
    protected static ?string $model = BudgetYear::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BudgetYearForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BudgetYearsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            IncomesRelationManager::class,
            FinancingRelationManager::class,
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBudgetYears::route('/'),
            'create' => CreateBudgetYear::route('/create'),
            'edit' => EditBudgetYear::route('/{record}/edit'),
        ];
    }
}
