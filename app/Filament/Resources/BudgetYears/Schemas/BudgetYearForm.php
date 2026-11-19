<?php

namespace App\Filament\Resources\BudgetYears\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BudgetYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->label('Tahun Anggaran')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                FileUpload::make('report_pdf')
                    ->label('Laporan Resmi PDF')
                    ->disk('public')
                    ->directory('laporan-apbdes')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->nullable(),
            ]);
    }
}
