<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Beritas\BeritaResource;
use App\Filament\Resources\Dokumens\DokumenResource;
use App\Filament\Resources\Galleries\GalleryResource;
use App\Filament\Resources\Pembangunans\PembangunanResource;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Gallery;
use App\Models\Pembangunan;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardSummaryWidget extends StatsOverviewWidget
{
    protected static ?bool $isLazyLoaded = false;

    protected int|string|array $columnSpan = 'full';

    protected int|array|null $columns = ['default' => 2, '@xl' => 4];

    protected ?string $heading = 'Ringkasan Data';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $metrics = DB::query()
            ->selectSub(
                Berita::query()->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END)', ['terbit']),
                'published_news_count',
            )
            ->selectSub(
                Berita::query()->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END)', ['draft']),
                'draft_news_count',
            )
            ->selectSub(Gallery::query()->selectRaw('COUNT(*)'), 'gallery_count')
            ->selectSub(
                Pembangunan::query()->where('status', 'Sedang Berjalan')->selectRaw('COUNT(*)'),
                'running_project_count',
            )
            ->selectSub(
                Dokumen::query()->where('is_published', true)->selectRaw('COUNT(*)'),
                'published_document_count',
            )
            ->first();

        $stats = [];

        if (BeritaResource::canViewAny()) {
            $stats[] = Stat::make('Berita Terbit', (int) $metrics->published_news_count)
                ->description((int) $metrics->draft_news_count.' draf')
                ->icon(Heroicon::OutlinedNewspaper)
                ->url(BeritaResource::getUrl('index'));
        }

        if (GalleryResource::canViewAny()) {
            $stats[] = Stat::make('Foto Galeri', (int) $metrics->gallery_count)
                ->icon(Heroicon::OutlinedPhoto)
                ->url(GalleryResource::getUrl('index'));
        }

        if (PembangunanResource::canViewAny()) {
            $stats[] = Stat::make('Proyek Berjalan', (int) $metrics->running_project_count)
                ->icon(Heroicon::OutlinedBuildingOffice)
                ->url(PembangunanResource::getUrl('index'));
        }

        if (DokumenResource::canViewAny()) {
            $stats[] = Stat::make('Dokumen Publik Terbit', (int) $metrics->published_document_count)
                ->icon(Heroicon::OutlinedDocumentText)
                ->url(DokumenResource::getUrl('index'));
        }

        return $stats;
    }
}
