@include('filament.widgets.dashboard-styles')

<x-filament-widgets::widget>
    <section class="sipades-dashboard-widget-card">
        <div class="sipades-dashboard-widget-header">
            <div class="sipades-dashboard-widget-heading">
                <h2 class="sipades-dashboard-widget-title">Aktivitas Terakhir</h2>
                <p class="sipades-dashboard-widget-description">Lima berita terbaru.</p>
            </div>
            <span class="sipades-dashboard-widget-icon"><x-filament::icon icon="heroicon-o-newspaper" /></span>
        </div>

        @if ($news === [])
            <p class="sipades-dashboard-empty">Belum ada berita.</p>
        @else
            <ul class="sipades-dashboard-news-list">
                @foreach ($news as $item)
                    <li class="sipades-dashboard-news-item">
                        @if ($item['url'])
                            <a href="{{ $item['url'] }}" class="sipades-dashboard-news-link">
                                <span class="sipades-dashboard-news-main">
                                    <span class="sipades-dashboard-news-title">{{ $item['title'] }}</span>
                                    <span @class([
                                        'sipades-dashboard-news-status',
                                        'is-published' => $item['status'] === 'Terbit',
                                        'is-draft' => $item['status'] === 'Draf',
                                    ])>{{ $item['status'] }}</span>
                                </span>
                                <span class="sipades-dashboard-news-date">{{ $item['date'] }}</span>
                            </a>
                        @else
                            <div>
                                <span class="sipades-dashboard-news-main">
                                    <span class="sipades-dashboard-news-title">{{ $item['title'] }}</span>
                                    <span class="sipades-dashboard-news-status">{{ $item['status'] }}</span>
                                </span>
                                <span class="sipades-dashboard-news-date">{{ $item['date'] }}</span>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-filament-widgets::widget>
