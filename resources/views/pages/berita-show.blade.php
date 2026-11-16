@extends('layouts.page')
@section('title', $item['title'])
@section('content')
@php
  $others = collect(config('village.news'))->reject(fn ($n) => $n['title'] === $item['title'])->take(3);
  $paras = $item['content'] ?? [$item['excerpt']];
@endphp
<x-page-hero :title="$item['title']" :text="$item['category'] . ' · ' . $item['date']" :tabs="false" crumb="Informasi & Berita" :crumb-url="route('berita')" />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x grid lg:grid-cols-3 gap-10">
    <article class="lg:col-span-2">
      <div class="aspect-[16/9] overflow-hidden rounded-md bg-soft"><img class="img-cover" src="{{ $item['image'] }}" alt="{{ $item['title'] }}"></div>
      <div class="mt-6 grid gap-4 text-base sm:text-lg leading-relaxed max-w-prose">
        @foreach($paras as $p)<p>{{ $p }}</p>@endforeach
        @unless(isset($item['content']))<p class="text-sm text-muted">[Isi lengkap berita akan ditampilkan di sini.]</p>@endunless
      </div>
      <a href="{{ route('berita') }}" class="btn btn-ghost mt-8 w-full sm:w-auto">← Semua Berita</a>
    </article>
    @if($others->isNotEmpty())
      <aside>
        <h2 class="font-bold text-lg text-deep mb-4">Berita Lainnya</h2>
        @foreach($others as $n)<x-news-card :item="$n" />@endforeach
      </aside>
    @endif
  </div>
</section>
@endsection
