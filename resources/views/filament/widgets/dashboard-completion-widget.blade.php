@include('filament.widgets.dashboard-styles')

<x-filament-widgets::widget>
    <section class="sipades-dashboard-widget-card">
        <div class="sipades-dashboard-widget-header">
            <span class="sipades-dashboard-widget-icon is-warning">
                <x-filament::icon icon="heroicon-o-clipboard-document-check" />
            </span>
            <div class="sipades-dashboard-widget-heading">
                <h2 class="sipades-dashboard-widget-title">Perlu Dilengkapi</h2>
                <p class="sipades-dashboard-widget-description">Daftar data yang masih perlu diperiksa.</p>
            </div>
        </div>

        @if ($items === [])
            <div class="sipades-dashboard-complete">
                <x-filament::icon icon="heroicon-o-check-circle" />
                <span>Semua data sudah lengkap.</span>
            </div>
        @else
            <ul class="sipades-dashboard-checklist">
                @foreach ($items as $item)
                    <li class="sipades-dashboard-checklist-item">
                        <a href="{{ $item['url'] }}" class="sipades-dashboard-checklist-link">
                            <span class="sipades-dashboard-checklist-label">
                                <span class="sipades-dashboard-row-icon"><x-filament::icon :icon="$item['icon']" /></span>
                                <span>{{ $item['label'] }}</span>
                            </span>
                            <span class="sipades-dashboard-row-arrow"><x-filament::icon icon="heroicon-o-chevron-right" /></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-filament-widgets::widget>
