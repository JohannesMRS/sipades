<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\VillageSetting;
use App\Filament\Resources\BudgetYears\BudgetYearResource;
use App\Filament\Resources\Dokumens\DokumenResource;
use App\Filament\Resources\Pembangunans\PembangunanResource;
use App\Filament\Resources\PerangkatDesas\PerangkatDesaResource;
use App\Models\BudgetYear;
use App\Models\Dokumen;
use App\Models\Pembangunan;
use App\Models\PerangkatDesa;
use App\Models\VillageSetting as VillageSettingModel;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class DashboardCompletionWidget extends Widget
{
    protected static ?bool $isLazyLoaded = false;

    protected string $view = 'filament.widgets.dashboard-completion-widget';

    protected int|string|array $columnSpan = 1;

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $metrics = DB::query()
            ->selectSub(
                VillageSettingModel::query()->selectRaw(
                    'CASE WHEN COUNT(*) = 0 OR SUM(CASE WHEN population IS NULL OR population = 0 OR family_count IS NULL OR family_count = 0 OR hamlet_count IS NULL OR hamlet_count = 0 OR area_size IS NULL OR area_size = 0 THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END',
                ),
                'missing_village_statistics',
            )
            ->selectSub(
                PerangkatDesa::query()->where('is_active', true)->selectRaw('COUNT(*)'),
                'active_official_count',
            )
            ->selectSub(
                BudgetYear::query()->where('is_active', true)->selectRaw('COUNT(*)'),
                'active_budget_year_count',
            )
            ->selectSub(
                BudgetYear::query()
                    ->where('is_active', true)
                    ->whereDoesntHave('activities', fn ($query) => $query->where('realized_amount', '>', 0))
                    ->selectRaw('COUNT(*)'),
                'active_budget_years_without_realization_count',
            )
            ->selectSub(
                BudgetYear::query()->where('is_active', true)->orderBy('id')->limit(1)->select('id'),
                'active_budget_year_id',
            )
            ->selectSub(
                Dokumen::query()->where('is_published', true)->selectRaw('COUNT(*)'),
                'published_document_count',
            )
            ->selectSub(
                Pembangunan::query()
                    ->where('status', 'Sedang Berjalan')
                    ->where(fn ($query) => $query->whereNull('updated_at')->orWhere('updated_at', '<', now()->subDays(30)))
                    ->selectRaw('COUNT(*)'),
                'stale_running_project_count',
            )
            ->first();

        $items = [];

        if ((bool) $metrics->missing_village_statistics) {
            $items[] = [
                'label' => 'Lengkapi statistik desa',
                'icon' => Heroicon::OutlinedChartBar,
                'url' => VillageSetting::getUrl(),
            ];
        }

        if ((int) $metrics->active_official_count === 0 && PerangkatDesaResource::canViewAny()) {
            $items[] = [
                'label' => 'Tambahkan perangkat desa aktif',
                'icon' => Heroicon::OutlinedIdentification,
                'url' => PerangkatDesaResource::canCreate()
                    ? PerangkatDesaResource::getUrl('create')
                    : PerangkatDesaResource::getUrl('index'),
            ];
        }

        $activeBudgetYearIsIncomplete = (int) $metrics->active_budget_year_count === 0
            || (int) $metrics->active_budget_years_without_realization_count > 0;

        if ($activeBudgetYearIsIncomplete && BudgetYearResource::canViewAny()) {
            $activeBudgetYearId = $metrics->active_budget_year_id;

            $items[] = [
                'label' => 'Lengkapi rincian realisasi tahun anggaran aktif',
                'icon' => Heroicon::OutlinedBanknotes,
                'url' => $activeBudgetYearId
                    ? BudgetYearResource::getUrl('edit', ['record' => $activeBudgetYearId])
                    : (BudgetYearResource::canCreate()
                        ? BudgetYearResource::getUrl('create')
                        : BudgetYearResource::getUrl('index')),
            ];
        }

        if ((int) $metrics->published_document_count === 0 && DokumenResource::canViewAny()) {
            $items[] = [
                'label' => 'Terbitkan dokumen publik',
                'icon' => Heroicon::OutlinedDocumentText,
                'url' => DokumenResource::canCreate()
                    ? DokumenResource::getUrl('create')
                    : DokumenResource::getUrl('index'),
            ];
        }

        if ((int) $metrics->stale_running_project_count > 0 && PembangunanResource::canViewAny()) {
            $items[] = [
                'label' => 'Perbarui proyek yang sedang berjalan',
                'icon' => Heroicon::OutlinedBuildingOffice,
                'url' => PembangunanResource::getUrl('index'),
            ];
        }

        return ['items' => $items];
    }
}
