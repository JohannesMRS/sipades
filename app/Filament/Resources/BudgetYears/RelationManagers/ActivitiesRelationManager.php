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

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $title = 'Rincian Kegiatan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('budget_field_id')->label('Bidang')->relationship('field', 'name')->required(),
                TextInput::make('name')->label('Nama Kegiatan')->required(),
                TextInput::make('budget_amount')->label('Anggaran')->numeric()->minValue(0)->required(),
                TextInput::make('realized_amount')->label('Realisasi')->numeric()->minValue(0)->lte('budget_amount')->default(0)->required(),
                Select::make('status')->label('Status')->options([
                    'Belum Dimulai' => 'Belum Dimulai',
                    'Sedang Berjalan' => 'Sedang Berjalan',
                    'Selesai' => 'Selesai',
                ])->required()->default('Belum Dimulai'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('budget_field_id')
                    ->label('ID Bidang')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Kegiatan')
                    ->searchable(),
                TextColumn::make('budget_amount')
                    ->label('Anggaran')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('realized_amount')
                    ->label('Realisasi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                TextColumn::make('field.name')
                    ->label('Bidang')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
