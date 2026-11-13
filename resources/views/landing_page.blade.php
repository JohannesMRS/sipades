@php
  $v = config('village');
  $menu = ['beranda' => 'Beranda', 'profil' => 'Profil Desa', 'pemerintahan' => 'Pemerintahan', 'informasi' => 'Informasi', 'potensi' => 'Potensi Desa', 'kontak' => 'Kontak'];
  $cats = collect($v['gallery'])->pluck('cat')->unique();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $v['name'] }}</title>
  <meta name="description" content="Informasi, potensi, dan layanan {{ $v['name'] }} dalam satu platform digital.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:z-50 focus:bg-white focus:p-3">Lewati ke konten</a>

{{-- NAVBAR --}}
<header id="navbar" class="sticky top-0 z-40 bg-surface">
  <div class="container-x flex items-center justify-between h-16 gap-4">
    <a href="#beranda" class="flex items-center gap-2.5">
        <img src="{{ asset($v['logo']) }}" alt="Logo {{ $v['name'] }}" class="h-9 w-auto">
        {{-- <span class="font-display font-bold text-forest leading-tight">{{ $v['name'] }}</span> --}}
    </a>
    <nav class="hidden lg:flex gap-6" aria-label="Utama">
      @foreach($menu as $id => $label)<a data-nav href="#{{ $id }}" class="nav-link">{{ $label }}</a>@endforeach
    </nav>
    <a href="#transparansi" class="btn btn-primary hidden lg:inline-flex">Layanan Desa</a>
    <button id="nav-toggle" class="lg:hidden p-2 -mr-2" aria-expanded="false" aria-controls="mobile-menu" aria-label="Buka menu">
      <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <div id="mobile-menu" class="hidden lg:hidden border-t border-[var(--line)] bg-surface">
    <nav class="container-x py-3 grid" aria-label="Seluler">
      @foreach($menu as $id => $label)<a href="#{{ $id }}" class="py-3 font-display font-medium border-b border-[var(--line)]">{{ $label }}</a>@endforeach
      <a href="#transparansi" class="btn btn-primary mt-4">Layanan Desa</a>
    </nav>
  </div>
</header>

<main id="main">
{{-- HERO --}}
<section id="beranda" class="section pt-10 md:pt-16">
  <div class="container-x grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">
    <div class="reveal">
      <span class="badge mb-5">Website Resmi Desa</span>
      <p class="font-display text-sm font-semibold text-forest mb-3 tracking-wide">SELAMAT DATANG DI WEBSITE RESMI DESA</p>
      <h1 class="text-4xl md:text-5xl font-extrabold text-deep">Mengenal Desa, Membangun Masa Depan Bersama.</h1>
      <p class="mt-5 text-lg text-muted max-w-xl">Temukan informasi, potensi, dan berbagai layanan desa dalam satu platform digital yang mudah diakses oleh seluruh masyarakat.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="#profil" class="btn btn-primary">Jelajahi Desa</a>
        <a href="#informasi" class="btn btn-ghost">Lihat Informasi</a>
      </div>
    </div>
    <div class="relative reveal">
      <div class="absolute -z-10 -right-4 -bottom-4 w-3/4 h-3/4 bg-soft rounded-2xl"></div>
      <div class="aspect-[4/3] lg:aspect-[5/4] rounded-2xl overflow-hidden">
        <img class="img-cover" src="{{ $v['images']['hero'] }}" alt="Pemandangan desa (gambar contoh)" fetchpriority="high">
      </div>
      <div class="absolute left-3 bottom-3 md:-left-6 md:bottom-8 bg-surface rounded-xl border border-[var(--line)] px-4 py-3 flex items-center gap-3">
        <span class="grid place-items-center size-10 rounded-lg bg-light text-deep"><x-icon name="pin"/></span>
        <div><p class="font-display font-bold text-sm">{{ $v['name'] }}</p><p class="text-xs text-muted">{{ $v['tagline'] }}</p></div>
      </div>
    </div>
  </div>
</section>

{{-- STATISTIK --}}
<section aria-label="Statistik desa" class="pb-4">
  <div class="container-x grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($v['stats'] as $s)
      <div class="card p-5 md:p-6 reveal">
        <span class="text-deep"><x-icon :name="$s['icon']"/></span>
        <p class="mt-4 font-display text-2xl md:text-3xl font-extrabold text-forest">{{ $s['value'] }}</p>
        <p class="text-sm text-muted">{{ $s['label'] }}</p>
      </div>
    @endforeach
  </div>
</section>

{{-- PROFIL --}}
<section id="profil" class="section">
  <div class="container-x grid md:grid-cols-2 gap-10 lg:gap-16 items-center">
    <div class="aspect-[9/7] rounded-2xl overflow-hidden reveal"><img class="img-cover" loading="lazy" src="{{ $v['images']['profile'] }}" alt="Suasana desa (gambar contoh)"></div>
    <div class="reveal">
      <h2 class="text-3xl md:text-4xl font-bold text-deep">Mengenal Lebih Dekat Desa Kami</h2>
      <p class="mt-4 text-muted">[Deskripsi singkat desa. Ganti dengan profil resmi yang disetujui pemerintah desa.]</p>
      <p class="mt-3 text-muted">[Informasi sejarah atau letak geografis akan ditampilkan di sini setelah data tersedia.]</p>
      <a href="#" class="btn btn-ghost mt-6">Selengkapnya Tentang Desa</a>
    </div>
  </div>
</section>

{{-- PEMERINTAHAN --}}
<section id="pemerintahan" class="section pt-0">
  <div class="container-x">
    <x-section-heading title="Pemerintahan Desa" text="Perangkat desa yang melayani masyarakat." />
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
      @foreach($v['officials'] as $o)
        <figure class="card reveal">
          <div class="aspect-[5/6] overflow-hidden"><img class="img-cover" loading="lazy" src="{{ $o['photo'] }}" alt="Foto {{ $o['role'] }} (contoh)"></div>
          <figcaption class="p-4"><p class="font-display font-bold">{{ $o['name'] }}</p><p class="text-sm text-muted">{{ $o['role'] }}</p></figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>

{{-- INFORMASI & BERITA --}}
<section id="informasi" class="section bg-surface">
  <div class="container-x">
    <div class="flex flex-wrap items-end justify-between gap-4">
      <x-section-heading title="Informasi & Berita" text="Kabar terbaru, pengumuman penting, dan informasi publik." />
      <a href="#" class="btn btn-ghost mb-10">Lihat Semua Berita</a>
    </div>
    <div class="grid lg:grid-cols-2 gap-5">
      @foreach($v['news'] as $i => $n)<x-news-card :item="$n" :featured="$i === 0" />@endforeach
    </div>
  </div>
</section>

{{-- POTENSI --}}
<section id="potensi" class="section">
  <div class="container-x">
    <x-section-heading title="Potensi Desa" text="Wisata, usaha warga, hasil bumi, dan budaya yang menjadi kekuatan desa." />
    <div class="grid sm:grid-cols-2 lg:grid-cols-6 gap-5">
      @foreach($v['potentials'] as $i => $p)
        <article class="card reveal group relative {{ $i < 2 ? 'lg:col-span-3' : 'lg:col-span-2' }}">
          <div class="aspect-[4/3] overflow-hidden"><img class="img-cover" loading="lazy" src="{{ $p['image'] }}" alt=""></div>
          <div class="p-5">
            <span class="badge">{{ $p['category'] }}</span>
            <h3 class="mt-2 font-bold text-lg">{{ $p['title'] }}</h3>
            <p class="text-sm text-muted">{{ $p['text'] }}</p>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- TRANSPARANSI --}}
<section id="transparansi" class="section bg-soft">
  <div class="container-x">
    <x-section-heading title="Transparansi & Informasi Publik" text="Ruang informasi terbuka bagi seluruh warga. Dokumen akan tersedia setelah diunggah oleh pemerintah desa." />
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach($v['transparency'] as $t)
        <a href="#" class="card p-6 reveal block">
          <span class="grid place-items-center size-11 rounded-lg bg-light text-deep"><x-icon :name="$t['icon']"/></span>
          <h3 class="mt-4 font-bold">{{ $t['title'] }}</h3>
          <p class="text-sm text-muted">{{ $t['text'] }}</p>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- GALERI --}}
<section id="galeri" class="section">
  <div class="container-x">
    <x-section-heading title="Galeri Desa" text="Potret kegiatan dan lingkungan desa." />
    <div class="flex flex-wrap gap-2 mb-6" role="group" aria-label="Filter galeri">
      <button data-filter="all" aria-pressed="true" class="btn btn-ghost !py-1.5 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">Semua</button>
      @foreach($cats as $c)<button data-filter="{{ $c }}" aria-pressed="false" class="btn btn-ghost !py-1.5 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">{{ $c }}</button>@endforeach
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
      @foreach($v['gallery'] as $g)
        <button class="gal-item aspect-[4/3] rounded-lg overflow-hidden" data-cat="{{ $g['cat'] }}" data-full="{{ $g['src'] }}" data-alt="{{ $g['alt'] }}" aria-label="Perbesar: {{ $g['alt'] }}">
          <img class="img-cover" loading="lazy" src="{{ $g['src'] }}" alt="{{ $g['alt'] }}">
        </button>
      @endforeach
    </div>
  </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="section pt-0">
  <div class="container-x grid lg:grid-cols-2 gap-8">
    <div class="reveal">
      <h2 class="text-3xl md:text-4xl font-bold text-deep">Kontak & Lokasi</h2>
      <ul class="mt-6 grid gap-4">
        @foreach([['pin','Alamat','address'],['phone','Telepon','phone'],['mail','Email','email'],['clock','Jam Operasional','hours']] as [$ic,$lb,$k])
          <li class="flex gap-4">
            <span class="grid place-items-center size-10 shrink-0 rounded-lg bg-light text-deep"><x-icon :name="$ic" class="size-5"/></span>
            <div><p class="font-display font-semibold text-sm">{{ $lb }}</p><p class="text-muted">{{ $v['contact'][$k] }}</p></div>
          </li>
        @endforeach
      </ul>
      <a href="#" class="btn btn-primary mt-8">Hubungi Pemerintah Desa</a>
    </div>
    <div class="card min-h-72 reveal">
      @if($v['contact']['map_embed'])
        <iframe src="{{ $v['contact']['map_embed'] }}" title="Lokasi kantor desa" class="w-full h-full min-h-72" loading="lazy"></iframe>
      @else
        <div class="h-full min-h-72 grid place-items-center text-center bg-soft p-6 text-muted">
          <div><x-icon name="map" class="size-8 mx-auto text-deep"/><p class="mt-2 text-sm">Peta Google Maps akan ditampilkan di sini.</p></div>
        </div>
      @endif
    </div>
  </div>
</section>
</main>

{{-- FOOTER --}}
<footer class="bg-deep text-white">
  <div class="container-x py-14 grid sm:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
    <div class="flex items-center gap-2.5">
        <span class="grid place-items-center rounded-lg bg-white p-1.5">
            <img src="{{ asset($v['logo']) }}" alt="Logo {{ $v['name'] }}" class="h-8 w-auto">
        </span>
        <span class="font-display font-bold">{{ $v['name'] }}</span>
    </div>
    <div><h3 class="font-bold mb-4">Tautan Cepat</h3><ul class="grid gap-2 text-white/75">
      @foreach($menu as $id => $label)<li><a class="hover:text-white" href="#{{ $id }}">{{ $label }}</a></li>@endforeach</ul></div>
    <div><h3 class="font-bold mb-4">Informasi Publik</h3><ul class="grid gap-2 text-white/75">
      @foreach($v['transparency'] as $t)<li><a class="hover:text-white" href="#transparansi">{{ $t['title'] }}</a></li>@endforeach</ul></div>
    <div><h3 class="font-bold mb-4">Kontak</h3><ul class="grid gap-2 text-white/75">
      <li>{{ $v['contact']['address'] }}</li><li>{{ $v['contact']['phone'] }}</li><li>{{ $v['contact']['email'] }}</li></ul></div>
  </div>
  <div class="border-t border-white/15">
    <div class="container-x py-5 flex flex-wrap justify-between gap-3 text-xs text-white/70">
      <p>© {{ date('Y') }} {{ $v['name'] }}. Hak cipta dilindungi.</p>
      <p class="flex gap-4"><a href="#" class="hover:text-white">Kebijakan Privasi</a><a href="#" class="hover:text-white">Syarat Layanan</a></p>
    </div>
  </div>
</footer>

<dialog id="lightbox" aria-label="Pratinjau gambar">
  <button data-close class="absolute right-3 top-3 btn btn-primary !p-2" aria-label="Tutup">✕</button>
  <img id="lightbox-img" class="block w-full max-h-[85vh] object-contain" src="" alt="">
</dialog>
</body>
</html>
