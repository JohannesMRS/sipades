<?php

namespace App\Filament\Pages;

use App\Models\VillageSetting as VillageSettingModel;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class VillageSetting extends Page
{
    public ?array $data = [];

    protected static ?string $navigationLabel = 'Pengaturan Desa';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Desa';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Pengaturan Desa';

    protected string $view = 'filament.pages.village-setting';

    public function mount(): void
    {
        $setting = VillageSettingModel::query()->find(1);

        if (! $setting) {
            $setting = VillageSettingModel::query()->create([
                'name' => '—',
                'area_unit' => 'km²',
            ]);
        }

        $this->form->fill($setting->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->model(VillageSettingModel::class)
            ->statePath('data')
            ->components([
                Tabs::make('Pengaturan Desa')
                    ->tabs([
                        Tab::make('Umum')
                            ->schema([
                                TextInput::make('name')->label('Nama Desa')->required(),
                                TextInput::make('tagline')->label('Tagline'),
                                FileUpload::make('logo')->label('Logo')->image()->disk('public')->directory('desa')->nullable(),
                            ])
                            ->columns(2),
                        Tab::make('Statistik')
                            ->schema([
                                TextInput::make('population')->label('Jumlah Penduduk')->numeric()->minValue(0)->nullable(),
                                TextInput::make('family_count')->label('Kepala Keluarga')->numeric()->minValue(0)->nullable(),
                                TextInput::make('hamlet_count')->label('Jumlah Dusun')->numeric()->minValue(0)->nullable(),
                                TextInput::make('area_size')->label('Luas Wilayah')->numeric()->minValue(0)->nullable(),
                                TextInput::make('area_unit')->label('Satuan Luas')->default('km²')->required(),
                            ])
                            ->columns(2),
                        Tab::make('Kontak')
                            ->schema([
                                Textarea::make('address')->label('Alamat')->rows(3)->columnSpanFull(),
                                TextInput::make('phone')->label('Telepon')->tel(),
                                TextInput::make('email')->label('Email')->email(),
                                TextInput::make('operational_hours')->label('Jam Operasional'),
                                Textarea::make('map_embed')->label('Embed Peta')->rows(3)->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Profil')
                            ->schema([
                                Textarea::make('deskripsi_singkat')
                                    ->label('Deskripsi Singkat')
                                    ->helperText('Tampil di beranda. Tulis 2 sampai 3 kalimat.')
                                    ->maxLength(400)
                                    ->rows(4)
                                    ->columnSpanFull(),
                                FileUpload::make('foto_profil')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(3072)
                                    ->disk('public')
                                    ->directory('profil')
                                    ->visibility('public')
                                    ->imagePreviewHeight('250')
                                    ->panelLayout('integrated')
                                    ->panelAspectRatio('9:7')
                                    ->imageEditor()
                                    ->imageEditorAspectRatioOptions(['9:7'])
                                    ->columnSpanFull(),
                                RichEditor::make('sejarah')
                                    ->label('Sejarah Desa')
                                    ->columnSpanFull(),
                                Textarea::make('visi')
                                    ->label('Visi Desa')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Repeater::make('misi')
                                    ->label('Misi Desa')
                                    ->simple(TextInput::make('item')->label('Poin Misi'))
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Poin Misi')
                                    ->columnSpanFull(),
                                RichEditor::make('letak_geografis')
                                    ->label('Letak Geografis')
                                    ->columnSpanFull(),
                                TextInput::make('batas_utara')->label('Batas Wilayah Utara'),
                                TextInput::make('batas_selatan')->label('Batas Wilayah Selatan'),
                                TextInput::make('batas_timur')->label('Batas Wilayah Timur'),
                                TextInput::make('batas_barat')->label('Batas Wilayah Barat'),
                            ])
                            ->columns(2),
                    ])
                    ->contained(false),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        VillageSettingModel::query()->updateOrCreate(['id' => 1], $data);

        Notification::make()->title('Pengaturan desa berhasil disimpan')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Simpan')->submit('save'),
        ];
    }
}
