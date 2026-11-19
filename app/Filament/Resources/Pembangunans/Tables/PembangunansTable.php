<?php

namespace App\Filament\Resources\Pembangunans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembangunansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->wrap(),
                TextColumn::make('category')->label('Kategori')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->searchable(),
                TextColumn::make('progress')->label('Progres')->suffix('%')->sortable(),
                TextColumn::make('budget')->label('Anggaran')->money('IDR')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
