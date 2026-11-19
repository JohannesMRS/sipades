<?php

namespace App\Providers;

use App\Models\PerangkatDesa;
use App\Models\VillageSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('landing_page', function ($view): void {
            $fallback = config('village', []);
            $setting = VillageSetting::query()->find(1);
            $officials = PerangkatDesa::query()->activeOrdered()->get(['name', 'position', 'image'])->map(fn (PerangkatDesa $official): array => [
                'name' => $official->name ?: '—',
                'role' => $official->position ?: '—',
                'photo' => $official->image
                    ? (str_starts_with($official->image, 'http://') || str_starts_with($official->image, 'https://')
                        ? $official->image
                        : '/storage/'.ltrim($official->image, '/'))
                    : '',
            ])->all();

            $address = $setting?->address ?: ($fallback['contact']['address'] ?? '—');
            $mapEmbed = $setting?->map_embed ?: 'https://www.google.com/maps?q='.urlencode((string) $address).'&output=embed';
            $mapLink = 'https://www.google.com/maps/search/?api=1&query='.urlencode((string) $address);

            $village = $fallback;
            $village['name'] = $setting?->name ?: ($fallback['name'] ?? '—');
            $village['tagline'] = $setting?->tagline ?: ($fallback['tagline'] ?? '—');
            $village['logo'] = $setting?->logo ?: ($fallback['logo'] ?? 'images/logo.png');
            $village['officials'] = $officials ?: ($fallback['officials'] ?? []);
            $village['stats'] = [
                ['icon' => 'users', 'value' => $setting?->population === null ? '—' : number_format((int) $setting->population, 0, ',', '.'), 'label' => 'Jumlah Penduduk'],
                ['icon' => 'home', 'value' => $setting?->family_count === null ? '—' : number_format((int) $setting->family_count, 0, ',', '.'), 'label' => 'Kepala Keluarga'],
                ['icon' => 'map', 'value' => $setting?->hamlet_count === null ? '—' : number_format((int) $setting->hamlet_count, 0, ',', '.'), 'label' => 'Dusun'],
                ['icon' => 'area', 'value' => $setting?->area_size === null ? '—' : number_format((float) $setting->area_size, 1, ',', '.').' '.($setting->area_unit ?: 'km²'), 'label' => 'Luas Wilayah'],
            ];
            $village['contact'] = [
                'address' => $address,
                'phone' => $setting?->phone ?: '—',
                'email' => $setting?->email ?: '—',
                'hours' => $setting?->operational_hours ?: '—',
                'map_embed' => $mapEmbed,
                'map_link' => $mapLink,
            ];

            $view->with('v', $village);
        });
    }
}
