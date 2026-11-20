<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardCompletionWidget;
use App\Filament\Widgets\DashboardQuickActionsWidget;
use App\Filament\Widgets\DashboardRecentNewsWidget;
use App\Filament\Widgets\DashboardSummaryWidget;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Widget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Home;

    protected static ?int $navigationSort = -2;

    public function getSubheading(): ?string
    {
        $user = Filament::auth()->user();
        $role = $user instanceof User && $user->isAdmin() ? 'Admin' : 'Operator';
        $name = $user instanceof User ? $user->name : 'Pengguna';

        return 'Selamat datang, '.$name.'. Peran: '.$role;
    }

    /**
     * @return array<class-string<Widget>>
     */
    public function getWidgets(): array
    {
        return [
            DashboardSummaryWidget::class,
            DashboardCompletionWidget::class,
            DashboardRecentNewsWidget::class,
            DashboardQuickActionsWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
