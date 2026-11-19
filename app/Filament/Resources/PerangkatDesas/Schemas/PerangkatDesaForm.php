<?php

namespace App\Filament\Resources\PerangkatDesas\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PerangkatDesaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('position')->label('Jabatan')->required(),
                FileUpload::make('image')
                    ->label('Foto')
                    ->image()
                    ->disk('public')
                    ->directory('perangkat-desa')
                    ->visibility('public')
                    ->fetchFileInformation(false)
                    ->getUploadedFileUsing(static function ($component, string $file): ?array {
                        if (filter_var($file, FILTER_VALIDATE_URL) !== false) {
                            return [
                                'name' => basename((string) parse_url($file, PHP_URL_PATH)),
                                'size' => 0,
                                'type' => 'image/jpeg',
                                'url' => $file,
                            ];
                        }

                        $disk = $component->getDisk();

                        if (! $disk->exists($file)) {
                            return null;
                        }

                        return [
                            'name' => basename($file),
                            'size' => $disk->size($file),
                            'type' => $disk->mimeType($file),
                            'url' => $disk->url($file),
                        ];
                    })
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
