@include('filament.widgets.dashboard-styles')

<x-filament-widgets::widget>
    <section class="sipades-dashboard-widget-card">
        <div class="sipades-dashboard-widget-header">
            <div class="sipades-dashboard-widget-heading">
                <h2 class="sipades-dashboard-widget-title">Aksi Cepat</h2>
                <p class="sipades-dashboard-widget-description">Pintasan untuk pekerjaan yang sering dilakukan.</p>
            </div>
        </div>

        <div class="sipades-dashboard-actions">
            @foreach ($actions as $action)
                <a
                    href="{{ $action['url'] }}"
                    @if (! empty($action['external']))
                        target="_blank"
                        rel="noopener noreferrer"
                    @endif
                    class="sipades-dashboard-action"
                >
                    <x-filament::icon :icon="$action['icon']" />
                    <span>{{ $action['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
</x-filament-widgets::widget>
