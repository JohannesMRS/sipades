<?php

namespace App\Filament\Resources\PotensiDesas\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PotensiDesaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required(),
            Select::make('category')->label('Kategori')->options([
                'Wisata Desa' => 'Wisata Desa',
                'UMKM' => 'UMKM',
                'Pertanian' => 'Pertanian',
                'Produk Lokal' => 'Produk Lokal',
                'Budaya dan Tradisi' => 'Budaya dan Tradisi',
            ])->required(),
            Textarea::make('description')->label('Deskripsi')->required()->columnSpanFull(),
            FileUpload::make('image')->label('Gambar')->image()->disk('public')->directory('potensi-desa')
                ->visibility('public')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(2048)->nullable(),
            TextInput::make('sort_order')->label('Urutan')->numeric()->default(0)->required(),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }
}
