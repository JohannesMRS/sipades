@extends('layouts.page')
@section('title', 'Profil Desa')
@if(filled($setting?->deskripsi_singkat))
  @section('meta-description', $setting->deskripsi_singkat)
@endif
@section('content')
<x-page-hero title="Profil Desa" :text="$heroText" :tabs="false" crumb="Beranda" :crumb-url="url('/')" />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x grid gap-6 sm:gap-8">
    @if($hasProfileContent)
      @if($photoUrl || filled($setting?->deskripsi_singkat))
        <section class="panel grid gap-5 p-5 sm:gap-8 sm:p-8 lg:grid-cols-2 lg:items-center">
          @if($photoUrl)
            <div class="overflow-hidden rounded-lg bg-soft">
              <img src="{{ $photoUrl }}" alt="Foto profil {{ $villageName }}" class="aspect-9/7 w-full object-cover" loading="lazy">
            </div>
          @endif
          @if(filled($setting?->deskripsi_singkat))
            <div class="max-w-prose">
              <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Mengenal Lebih Dekat {{ $villageName }}</h2>
              <p class="mt-3 leading-relaxed text-muted">{{ $setting->deskripsi_singkat }}</p>
            </div>
          @endif
        </section>
      @endif

      @if($hasHistory)
        <section class="panel p-5 sm:p-8">
          <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Sejarah Desa</h2>
          <div class="prose mt-4 max-w-prose leading-relaxed text-muted">{!! $history !!}</div>
        </section>
      @endif

      @if(filled($setting?->visi) || $missions->isNotEmpty())
        <section class="panel grid gap-6 p-5 sm:p-8 lg:grid-cols-2">
          @if(filled($setting?->visi))
            <div>
              <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Visi Desa</h2>
              <blockquote class="mt-4 border-l-4 border-(--amber) pl-4 text-lg leading-relaxed text-ink sm:text-xl">
                {{ $setting->visi }}
              </blockquote>
            </div>
          @endif
          @if($missions->isNotEmpty())
            <div>
              <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Misi Desa</h2>
              <ol class="mt-4 list-decimal space-y-3 pl-5 leading-relaxed text-muted">
                @foreach($missions as $mission)
                  <li>{{ $mission }}</li>
                @endforeach
              </ol>
            </div>
          @endif
        </section>
      @endif

      @if($hasGeographicLocation || $boundaries->isNotEmpty())
        <section class="panel p-5 sm:p-8">
          <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Letak Geografis</h2>
          @if($hasGeographicLocation)
            <div class="prose mt-4 max-w-prose leading-relaxed text-muted">{!! $geographicLocation !!}</div>
          @endif
          @if($boundaries->isNotEmpty())
            <dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
              @foreach($boundaries as $direction => $neighbor)
                <div class="rounded-lg bg-soft p-4">
                  <dt class="text-sm font-semibold text-deep">Sebelah {{ $direction }}</dt>
                  <dd class="mt-1 wrap-break-word text-sm text-muted">{{ $neighbor }}</dd>
                </div>
              @endforeach
            </dl>
          @endif
        </section>
      @endif

      @if($summary->isNotEmpty())
        <section class="panel p-5 sm:p-8">
          <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Data Ringkas</h2>
          <dl class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($summary as $label => $value)
              <div class="rounded-lg bg-soft p-4">
                <dt class="text-xs leading-relaxed text-muted sm:text-sm">{{ $label }}</dt>
                <dd class="mt-1 wrap-break-word font-display text-lg font-bold text-forest sm:text-xl">{{ $value }}</dd>
              </div>
            @endforeach
          </dl>
        </section>
      @endif

      <div class="flex justify-center">
        <a href="{{ url('/') }}#pemerintahan" class="btn btn-ghost w-full sm:w-auto">Lihat Perangkat Desa</a>
      </div>
    @else
      <div class="panel mx-auto w-full max-w-2xl p-6 text-center sm:p-10">
        <h2 class="font-display text-xl font-bold text-deep sm:text-2xl">Profil lengkap desa belum tersedia.</h2>
        <p class="mt-2 text-sm leading-relaxed text-muted">Informasi profil desa akan ditampilkan setelah dilengkapi.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-6 w-full sm:w-auto">Kembali ke Beranda</a>
      </div>
    @endif
  </div>
</section>
@endsection
