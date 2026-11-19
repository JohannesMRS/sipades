<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required(),
            Select::make('category')->label('Kategori')->options([
                'Peraturan Desa' => 'Peraturan Desa',
                'APBDes' => 'APBDes',
                'Laporan Keuangan' => 'Laporan Keuangan',
                'RPJMDes dan RKPDes' => 'RPJMDes dan RKPDes',
                'Laporan Kinerja' => 'Laporan Kinerja',
                'Lainnya' => 'Lainnya',
            ])->required(),
            TextInput::make('year')->label('Tahun')->numeric()->required(),
            FileUpload::make('file')->label('File')->disk('public')->directory('dokumen-publik')
                ->visibility('public')
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                ->maxSize(10240)->required(),
            Textarea::make('description')->label('Deskripsi')->rows(4),
            Toggle::make('is_published')->label('Terbit')->default(false),
        ]);
    }
}
