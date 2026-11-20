<?php

namespace App\Http\Controllers;

use App\Models\VillageSetting;
use App\Support\NewsHtml;
use Illuminate\View\View;

class ProfileDesaController extends Controller
{
    public function __invoke(): View
    {
        $setting = VillageSetting::query()->find(1);
        $history = NewsHtml::sanitize((string) $setting?->sejarah);
        $geographicLocation = NewsHtml::sanitize((string) $setting?->letak_geografis);
        $missions = collect(is_array($setting?->misi) ? $setting->misi : [])
            ->map(fn (mixed $mission): string => trim((string) $mission))
            ->filter()
            ->values();
        $boundaries = collect([
            'Utara' => $setting?->batas_utara,
            'Selatan' => $setting?->batas_selatan,
            'Timur' => $setting?->batas_timur,
            'Barat' => $setting?->batas_barat,
        ])->filter(fn (?string $value): bool => filled($value));
        $summary = collect([
            'Jumlah Penduduk' => filled($setting?->population) && (int) $setting->population > 0
                ? number_format((int) $setting->population, 0, ',', '.')
                : null,
            'Kepala Keluarga' => filled($setting?->family_count) && (int) $setting->family_count > 0
                ? number_format((int) $setting->family_count, 0, ',', '.')
                : null,
            'Jumlah Dusun' => filled($setting?->hamlet_count) && (int) $setting->hamlet_count > 0
                ? number_format((int) $setting->hamlet_count, 0, ',', '.')
                : null,
            'Luas Wilayah' => filled($setting?->area_size) && (float) $setting->area_size > 0
                ? number_format((float) $setting->area_size, 2, ',', '.').' '.($setting->area_unit ?: 'km²')
                : null,
        ])->filter();
        $photo = $setting?->foto_profil;
        $photoUrl = filled($photo)
            ? (str_starts_with($photo, 'http://') || str_starts_with($photo, 'https://')
                ? $photo
                : '/storage/'.ltrim($photo, '/'))
            : null;
        $hasHistory = filled(trim(strip_tags($history)));
        $hasGeographicLocation = filled(trim(strip_tags($geographicLocation)));
        $hasProfileContent = filled($setting?->deskripsi_singkat)
            || filled($photoUrl)
            || $hasHistory
            || filled($setting?->visi)
            || $missions->isNotEmpty()
            || $hasGeographicLocation
            || $boundaries->isNotEmpty()
            || $summary->isNotEmpty();
        $villageName = $setting?->name ?: 'Desa';
        $heroText = trim($villageName.' '.($setting?->tagline ?? ''));

        return view('pages.profil-desa', compact(
            'setting',
            'history',
            'geographicLocation',
            'missions',
            'boundaries',
            'summary',
            'photoUrl',
            'hasHistory',
            'hasGeographicLocation',
            'hasProfileContent',
            'villageName',
            'heroText',
        ));
    }
}
