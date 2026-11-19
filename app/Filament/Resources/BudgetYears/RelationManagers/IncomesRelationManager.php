<?php

namespace App\Filament\Resources\BudgetYears\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncomesRelationManager extends RelationManager
{
    protected static string $relationship = 'incomes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('group')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('budget_amount')
                    ->label('Anggaran')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('realized_amount')
                    ->label('Realisasi')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->lte('budget_amount')
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('group')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('budget_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('realized_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                //
            ]);
    }
}
