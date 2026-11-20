<?php

namespace App\Filament\Pages;

use App\Models\VillageSetting as VillageSettingModel;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
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
                TextInput::make('name')->label('Nama Desa')->required(),
                TextInput::make('tagline')->label('Tagline'),
                FileUpload::make('logo')->label('Logo')->image()->disk('public')->directory('desa')->nullable(),
                TextInput::make('population')->label('Jumlah Penduduk')->numeric()->minValue(0)->nullable(),
                TextInput::make('family_count')->label('Kepala Keluarga')->numeric()->minValue(0)->nullable(),
                TextInput::make('hamlet_count')->label('Jumlah Dusun')->numeric()->minValue(0)->nullable(),
                TextInput::make('area_size')->label('Luas Wilayah')->numeric()->minValue(0)->nullable(),
                TextInput::make('area_unit')->label('Satuan Luas')->default('km²')->required(),
                Textarea::make('address')->label('Alamat')->rows(3),
                TextInput::make('phone')->label('Telepon')->tel(),
                TextInput::make('email')->label('Email')->email(),
                TextInput::make('operational_hours')->label('Jam Operasional'),
                Textarea::make('map_embed')->label('Embed Peta')->rows(3),
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
