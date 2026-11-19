<?php

namespace App\Filament\Resources\BeritaCategories;

use App\Filament\Resources\BeritaCategories\Pages\CreateBeritaCategory;
use App\Filament\Resources\BeritaCategories\Pages\EditBeritaCategory;
use App\Filament\Resources\BeritaCategories\Pages\ListBeritaCategories;
use App\Filament\Resources\BeritaCategories\Schemas\BeritaCategoryForm;
use App\Filament\Resources\BeritaCategories\Tables\BeritaCategoriesTable;
use App\Models\BeritaCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BeritaCategoryResource extends Resource
{
    protected static ?string $model = BeritaCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Kategori Berita';

    protected static ?string $modelLabel = 'Kategori Berita';

    protected static ?string $pluralModelLabel = 'Kategori Berita';

    public static function form(Schema $schema): Schema
    {
        return BeritaCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeritaCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeritaCategories::route('/'),
            'create' => CreateBeritaCategory::route('/create'),
            'edit' => EditBeritaCategory::route('/{record}/edit'),
        ];
    }
}
