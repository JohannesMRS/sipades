<?php

namespace App\Filament\Resources\Pembangunans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PembangunanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama Proyek')->required(),
            TextInput::make('location')->label('Lokasi')->required(),
            TextInput::make('category')->label('Bidang / Kategori')->required(),
            TextInput::make('budget')->label('Anggaran')->numeric()->minValue(0)->required(),
            DatePicker::make('start_date')->label('Tanggal Mulai')->required(),
            DatePicker::make('end_date')->label('Estimasi Selesai')->required(),
            Select::make('status')->label('Status')->options([
                'Selesai' => 'Selesai',
                'Sedang Berjalan' => 'Sedang Berjalan',
                'Akan Dilaksanakan' => 'Akan Dilaksanakan',
            ])->live()->required(),
            TextInput::make('progress')->label('Progres (%)')->numeric()->minValue(0)->maxValue(100)
                ->required()
                ->disabled(fn ($get) => in_array($get('status'), ['Selesai', 'Akan Dilaksanakan'], true))
                ->dehydrateStateUsing(fn ($state, $get) => match ($get('status')) {
                    'Selesai' => 100,
                    'Akan Dilaksanakan' => 0,
                    default => (int) $state,
                }),
            TextInput::make('source')->label('Sumber Dana'),
            TextInput::make('executor')->label('Pelaksana'),
            FileUpload::make('image')->label('Gambar Utama')->image()->disk('public')->directory('pembangunan')
                ->visibility('public')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(2048)->nullable(),
            Textarea::make('description')->label('Deskripsi')->rows(5)->columnSpanFull(),
        ]);
    }
}
