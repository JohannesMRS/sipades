@props(['title', 'text'])
@php
  $tabs = [['apbdes', 'APBDes'], ['realisasi-anggaran', 'Realisasi Anggaran'], ['informasi-pembangunan', 'Informasi Pembangunan'], ['dokumen-publik', 'Dokumen Publik']];
@endphp
<section class="bg-photo text-white pt-10 pb-24 md:pb-28">
  <div class="container-x">
    <nav class="text-sm text-white/75" aria-label="Breadcrumb">
      <a href="{{ url('/') }}#layanan" class="hover:text-white">Layanan Desa</a> <span aria-hidden="true">/</span> <span class="text-white">{{ $title }}</span>
    </nav>
    <h1 class="mt-3 text-3xl sm:text-4xl md:text-5xl font-extrabold">{{ $title }}</h1>
    <p class="mt-3 max-w-2xl text-white/85">{{ $text }}</p>
    <div class="mt-7 flex gap-2 overflow-x-auto pb-1" aria-label="Halaman layanan">
      @foreach($tabs as [$path, $label])
        <a href="{{ url('/' . $path) }}" @class(['btn shrink-0', 'btn-light' => request()->is($path), 'btn-outline-light' => !request()->is($path)])>{{ $label }}</a>
      @endforeach
    </div>
  </div>
</section>
