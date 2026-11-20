<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Beritas\BeritaResource;
use App\Models\Berita;
use Filament\Widgets\Widget;

class DashboardRecentNewsWidget extends Widget
{
    protected static ?bool $isLazyLoaded = false;

    protected string $view = 'filament.widgets.dashboard-recent-news-widget';

    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return BeritaResource::canViewAny();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $news = Berita::query()
            ->latest('created_at')
            ->latest('id')
            ->limit(5)
            ->get(['id', 'title', 'status', 'published_at', 'created_at'])
            ->map(fn (Berita $item): array => [
                'title' => $item->title,
                'status' => match ($item->status) {
                    'terbit' => 'Terbit',
                    'draft' => 'Draf',
                    default => '—',
                },
                'date' => ($item->published_at ?? $item->created_at)?->locale('id')->translatedFormat('j F Y') ?? '—',
                'url' => BeritaResource::canEdit($item)
                    ? BeritaResource::getUrl('edit', ['record' => $item])
                    : null,
            ])
            ->all();

        return ['news' => $news];
    }
}
