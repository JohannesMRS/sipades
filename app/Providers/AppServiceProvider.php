<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Gallery;
use App\Models\PerangkatDesa;
use App\Models\PotensiDesa;
use App\Models\VillageSetting;
use Carbon\Carbon;
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
        Carbon::setLocale(config('app.locale'));

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

            $news = Berita::query()->published()->with('category')->orderByDesc('is_featured')->latest('published_at')->take(4)->get()->map(fn (Berita $berita): array => [
                'category' => $berita->category?->name ?? 'Berita',
                'date' => $berita->published_at?->translatedFormat('j F Y') ?? '—',
                'title' => $berita->title,
                'excerpt' => $berita->excerpt,
                'image' => $berita->image
                    ? (str_starts_with($berita->image, 'http://') || str_starts_with($berita->image, 'https://')
                        ? $berita->image
                        : '/storage/'.ltrim($berita->image, '/'))
                    : '',
                'url' => route('berita.show', $berita->slug),
                'content' => $berita->content ? [$berita->content] : null,
            ])->all();

            $potentials = PotensiDesa::query()->activeOrdered()->get(['title', 'category', 'description', 'image'])->map(fn (PotensiDesa $item): array => [
                'category' => $item->category ?: '—',
                'title' => $item->title ?: '—',
                'text' => $item->description ?: '—',
                'image' => $item->image
                    ? (str_starts_with($item->image, 'http://') || str_starts_with($item->image, 'https://')
                        ? $item->image
                        : '/storage/'.ltrim($item->image, '/'))
                    : '',
            ])->all();

            $gallery = Gallery::query()->activeOrdered()->get(['category', 'image', 'alt'])->map(fn (Gallery $item): array => [
                'cat' => $item->category ?: '—',
                'src' => $item->image
                    ? (str_starts_with($item->image, 'http://') || str_starts_with($item->image, 'https://')
                        ? $item->image
                        : '/storage/'.ltrim($item->image, '/'))
                    : '',
                'alt' => $item->alt ?: '—',
            ])->all();

            $address = $setting?->address ?: ($fallback['contact']['address'] ?? '—');
            $mapEmbed = $setting?->map_embed ?: 'https://www.google.com/maps?q='.urlencode((string) $address).'&output=embed';
            $mapLink = 'https://www.google.com/maps/search/?api=1&query='.urlencode((string) $address);

            $village = $fallback;
            $village['name'] = $setting?->name ?: ($fallback['name'] ?? '—');
            $village['tagline'] = $setting?->tagline ?: ($fallback['tagline'] ?? '—');
            $village['logo'] = $setting?->logo ?: ($fallback['logo'] ?? 'images/logo.png');
            $profileImage = $setting?->foto_profil;
            $profileMissions = is_array($setting?->misi) ? $setting->misi : [];
            $village['profile'] = [
                'description' => $setting?->deskripsi_singkat,
                'image' => filled($profileImage)
                    ? (str_starts_with($profileImage, 'http://') || str_starts_with($profileImage, 'https://')
                        ? $profileImage
                        : '/storage/'.ltrim($profileImage, '/'))
                    : '/images/desa.jpg',
                'has_content' => filled(trim(strip_tags((string) $setting?->sejarah)))
                    || filled($setting?->visi)
                    || collect($profileMissions)->contains(fn ($mission): bool => filled($mission))
                    || filled(trim(strip_tags((string) $setting?->letak_geografis)))
                    || filled($setting?->batas_utara)
                    || filled($setting?->batas_selatan)
                    || filled($setting?->batas_timur)
                    || filled($setting?->batas_barat),
            ];
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

            if ($news !== []) {
                $village['news'] = $news;
            }
            if ($potentials !== []) {
                $village['potentials'] = $potentials;
            }
            if ($gallery !== []) {
                $village['gallery'] = $gallery;
            }

            $view->with('v', $village);
        });
    }
}
