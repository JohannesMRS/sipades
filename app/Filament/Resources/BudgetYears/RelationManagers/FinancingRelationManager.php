<?php

namespace App\Filament\Resources\BudgetYears\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FinancingRelationManager extends RelationManager
{
    protected static string $relationship = 'financing';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')->label('Jenis')->options([
                    'Penerimaan' => 'Penerimaan',
                    'Pengeluaran' => 'Pengeluaran',
                ])->required(),
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('budget_amount')->label('Anggaran')->numeric()->minValue(0)->required(),
                TextInput::make('realized_amount')->label('Realisasi')->numeric()->minValue(0)->lte('budget_amount')->default(0)->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
