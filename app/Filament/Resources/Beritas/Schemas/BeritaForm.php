<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Judul')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Select::make('berita_category_id')->label('Kategori')->relationship('category', 'name')->required(),
                Textarea::make('excerpt')->label('Ringkasan')->required()->rows(4),
                RichEditor::make('content')->label('Isi'),
                FileUpload::make('image')->label('Gambar')->image()->disk('public')->directory('berita')
                    ->visibility('public')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(2048)->nullable(),
                Select::make('status')->label('Status')->options(['draft' => 'Draft', 'terbit' => 'Terbit'])->required()->default('draft'),
                DateTimePicker::make('published_at')->label('Tanggal Terbit')->native(false),
                Toggle::make('is_featured')->label('Disematkan')->default(false),
            ]);
    }
}
