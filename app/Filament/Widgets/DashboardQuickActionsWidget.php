<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Beritas\BeritaResource;
use App\Filament\Resources\Dokumens\DokumenResource;
use App\Filament\Resources\Galleries\GalleryResource;
use App\Filament\Resources\Pembangunans\PembangunanResource;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Widget;

class DashboardQuickActionsWidget extends Widget
{
    protected static ?bool $isLazyLoaded = false;

    protected string $view = 'filament.widgets.dashboard-quick-actions-widget';

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $actions = [];

        if (BeritaResource::canCreate()) {
            $actions[] = [
                'label' => 'Tulis Berita',
                'icon' => Heroicon::OutlinedPencilSquare,
                'url' => BeritaResource::getUrl('create'),
            ];
        }

        if (GalleryResource::canCreate()) {
            $actions[] = [
                'label' => 'Tambah Foto Galeri',
                'icon' => Heroicon::OutlinedPhoto,
                'url' => GalleryResource::getUrl('create'),
            ];
        }

        if (PembangunanResource::canViewAny()) {
            $actions[] = [
                'label' => 'Perbarui Proyek',
                'icon' => Heroicon::OutlinedBuildingOffice,
                'url' => PembangunanResource::getUrl('index'),
            ];
        }

        if (DokumenResource::canCreate()) {
            $actions[] = [
                'label' => 'Unggah Dokumen',
                'icon' => Heroicon::OutlinedDocumentArrowUp,
                'url' => DokumenResource::getUrl('create'),
            ];
        }

        $actions[] = [
            'label' => 'Lihat Website',
            'icon' => Heroicon::OutlinedArrowTopRightOnSquare,
            'url' => url('/'),
            'external' => true,
        ];

        return ['actions' => $actions];
    }
}
