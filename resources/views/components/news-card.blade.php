@props(['item', 'featured' => false])
<article class="card reveal {{ $featured ? 'lg:row-span-3 flex flex-col' : 'grid sm:grid-cols-[10rem_1fr]' }}">
  <div class="{{ $featured ? 'aspect-[16/10]' : 'aspect-[16/10] sm:aspect-auto' }} overflow-hidden">
    <img class="img-cover" loading="lazy" src="{{ $item['image'] }}" alt="">
  </div>
  <div class="p-5 flex flex-col gap-2">
    <div class="flex items-center gap-3 text-xs text-muted">
      <span class="badge {{ $item['category'] === 'Pengumuman' ? 'badge-warn' : '' }}">{{ $item['category'] }}</span>
      <time>{{ $item['date'] }}</time>
    </div>
    <h3 class="font-bold {{ $featured ? 'text-2xl' : 'text-base' }}">{{ $item['title'] }}</h3>
    <p class="text-sm text-muted">{{ $item['excerpt'] }}</p>
    <a href="{{ $item['url'] }}" class="link mt-auto pt-1">Baca Selengkapnya</a>
  </div>
</article>
