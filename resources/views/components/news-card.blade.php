@props(['item', 'featured' => false])
@php $warn = $item['category'] === 'Pengumuman'; @endphp

@if($featured)
  <article>
    <a href="{{ $item['url'] }}" class="group block">
      <div class="aspect-[16/10] overflow-hidden rounded-md">
        <img class="img-cover" loading="lazy" src="{{ $item['image'] }}" alt="">
      </div>
      <p class="mt-4 text-sm {{ $warn ? 'text-[var(--warn-text)]' : 'text-forest' }} font-semibold">
        {{ $item['category'] }} <span class="text-muted font-normal">· {{ $item['date'] }}</span>
      </p>
      <h3 class="mt-1 text-xl sm:text-2xl font-bold group-hover:underline">{{ $item['title'] }}</h3>
      <p class="mt-2 text-muted">{{ $item['excerpt'] }}</p>
    </a>
  </article>
@else
  <article class="py-4 first:pt-0 border-b border-[var(--line)] last:border-0">
    <a href="{{ $item['url'] }}" class="group flex gap-4 items-start">
      <div class="w-24 sm:w-32 shrink-0 aspect-[4/3] overflow-hidden rounded-md">
        <img class="img-cover" loading="lazy" src="{{ $item['image'] }}" alt="">
      </div>
      <div class="min-w-0">
        <p class="text-xs {{ $warn ? 'text-[var(--warn-text)]' : 'text-forest' }} font-semibold">
          {{ $item['category'] }} <span class="text-muted font-normal">· {{ $item['date'] }}</span>
        </p>
        <h3 class="mt-1 font-bold leading-snug group-hover:underline">{{ $item['title'] }}</h3>
        <p class="mt-1 text-sm text-muted line-clamp-2">{{ $item['excerpt'] }}</p>
      </div>
    </a>
  </article>
@endif
