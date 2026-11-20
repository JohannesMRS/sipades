<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard as DashboardPage;
use App\Models\VillageSetting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->brandName(fn (): string => (string) (VillageSetting::query()->value('name') ?: 'SIPADES'))
            ->brandLogo(function (): HtmlString {
                $setting = VillageSetting::query()->find(1);
                $logo = $setting?->logo;
                $logoUrl = filled($logo)
                    ? (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')
                        ? $logo
                        : asset('storage/'.ltrim($logo, '/')))
                    : asset('images/logo.png');
                $villageName = e((string) ($setting?->name ?: 'SIPADES'));

                return new HtmlString('<span style="display:flex;align-items:center;gap:.625rem;white-space:nowrap"><img src="'.e($logoUrl).'" alt="" style="height:2.5rem;width:auto"><span>'.$villageName.'</span></span>');
            })
            ->brandLogoHeight('2.5rem')
            ->favicon(function (): string {
                $logo = VillageSetting::query()->value('logo');

                if (blank($logo)) {
                    return asset('images/logo.png');
                }

                return str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')
                    ? $logo
                        : asset('storage/'.ltrim($logo, '/'));
            })
            ->darkMode(false)
            ->themeSwitcher(false)
            ->colors([
                'primary' => Color::hex('#166534'),
            ])
            ->navigationGroups([
                NavigationGroup::make('Pengaturan Desa')->collapsible(),
                NavigationGroup::make('Informasi')->collapsible(),
                NavigationGroup::make('Transparansi')->collapsible(),
                NavigationGroup::make('Pengguna')->collapsible(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                DashboardPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
