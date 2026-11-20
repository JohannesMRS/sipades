@php
  $v = $v ?? ['name' => 'Desa', 'logo' => 'images/logo.png', 'stats' => [], 'officials' => [], 'news' => [], 'potentials' => [], 'transparency' => [], 'gallery' => [], 'contact' => ['address' => '—', 'phone' => '—', 'email' => '—', 'hours' => '—', 'map_embed' => null, 'map_link' => '#'], 'images' => ['profile' => 'images/desa.jpg']];
  $menu = ['beranda' => 'Beranda', 'profil' => 'Profil Desa', 'pemerintahan' => 'Pemerintahan', 'informasi' => 'Informasi', 'potensi' => 'Potensi Desa', 'layanan' => 'Layanan Desa', 'kontak' => 'Kontak'];
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
<header id="navbar" class="fixed inset-x-0 top-0 z-40">
  <div class="container-x flex items-center justify-between h-16 lg:h-[4.5rem] gap-4">
    <a href="#beranda" class="flex items-center gap-2.5" aria-label="{{ $v['name'] }}">
      <span class="flex rounded-md bg-white p-1"><img src="{{ asset($v['logo']) }}" alt="Logo {{ $v['name'] }}" class="h-8 w-auto"></span>
      <span class="font-display font-bold text-white hidden sm:block">{{ $v['name'] }}</span>
    </a>
    <nav class="hidden lg:flex gap-5 xl:gap-7" aria-label="Utama">
      @foreach($menu as $id => $label)<a data-nav href="#{{ $id }}" class="nav-link">{{ $label }}</a>@endforeach
    </nav>
    <button id="nav-toggle" class="burger lg:hidden grid place-items-center size-11 -mr-2" aria-expanded="false" aria-controls="mobile-menu" aria-label="Buka menu">
      <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <div id="mobile-menu" class="hidden lg:hidden bg-surface border-t border-[var(--line)] shadow-lg">
    <nav class="container-x py-2 grid" aria-label="Seluler">
      @foreach($menu as $id => $label)
        <a href="#{{ $id }}" class="py-3.5 font-display font-medium text-ink border-b border-[var(--line)] last:border-0">{{ $label }}</a>
      @endforeach
    </nav>
  </div>
</header>

<main id="main">
{{-- HERO --}}
<section id="beranda" class="relative isolate min-h-[100svh] flex items-end text-white">
  <img src="{{ asset('images/desa.jpg') }}" alt="Pemandangan {{ $v['name'] }}" class="absolute inset-0 -z-10 size-full object-cover" fetchpriority="high">
  <div class="absolute inset-0 -z-10 hero-shade"></div>
  <div class="container-x pt-32 pb-32 md:pb-36">
    <div class="max-w-2xl">
      <p class="text-white/85 mb-3">Selamat datang di website resmi {{ $v['name'] }}</p>
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold">Mengenal Desa, Membangun Masa Depan Bersama.</h1>
      <p class="mt-5 text-base sm:text-lg text-white/85 max-w-xl">Temukan informasi, potensi, dan berbagai layanan desa dalam satu platform digital yang mudah diakses oleh seluruh masyarakat.</p>
      <div class="mt-8 flex flex-col sm:flex-row gap-3">
        <a href="#profil" class="btn btn-light">Jelajahi Desa</a>
        <a href="#informasi" class="btn btn-outline-light">Lihat Informasi</a>
      </div>
    </div>
  </div>
</section>

{{-- STATISTIK --}}
<section aria-label="Statistik desa" class="relative z-10 -mt-14 md:-mt-16">
  <div class="container-x">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-[var(--line)] rounded-lg overflow-hidden border border-[var(--line)] shadow-sm">
      @foreach($v['stats'] as $s)
        <div class="bg-surface p-4 sm:p-6 flex items-center gap-3 sm:gap-4">
          <span class="text-deep shrink-0 hidden sm:block"><x-icon :name="$s['icon']" class="size-7"/></span>
          <div>
            <p class="font-display text-xl sm:text-3xl font-extrabold text-forest leading-none">{{ $s['value'] }}</p>
            <p class="mt-1 text-xs sm:text-sm text-muted">{{ $s['label'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- PROFIL --}}
<section id="profil" class="section curve bg-photo text-white !mt-12 md:!mt-16">
  <div class="container-x grid md:grid-cols-2 gap-10 md:gap-16 items-center">
    <div class="relative order-2 md:order-1 reveal">
      <div class="absolute inset-0 translate-x-3 translate-y-3 md:translate-x-4 md:translate-y-4 rounded-md border-2 border-[var(--amber)]"></div>
      <div class="relative aspect-[9/7] overflow-hidden rounded-md bg-soft">
        <img class="img-cover" loading="lazy" src="{{ $v['profile']['image'] ?? '/images/desa.jpg' }}" alt="Suasana {{ $v['name'] }}">
      </div>
    </div>
    <div class="order-1 md:order-2 reveal">
      <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold">Mengenal Lebih Dekat Desa Kami</h2>
      @if(filled($v['profile']['description'] ?? null))
        <p class="mt-4 text-white/85">{{ $v['profile']['description'] }}</p>
      @endif
      @if($v['profile']['has_content'] ?? false)
        <a href="{{ route('profil-desa') }}" class="btn btn-light mt-6 w-full sm:w-auto">Selengkapnya Tentang Desa</a>
      @endif
    </div>
  </div>
</section>

{{-- PEMERINTAHAN --}}
<section id="pemerintahan" class="section curve bg-soft dots">
  <div class="container-x">
    <x-section-heading class="reveal" title="Pemerintahan Desa" text="Perangkat desa yang melayani masyarakat." />
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10 md:gap-x-8">
      @foreach($v['officials'] as $o)
        <figure class="text-center reveal">
          <div class="aspect-[4/5] overflow-hidden rounded-t-full border-4 border-white bg-white shadow-sm">
            <img class="img-cover" loading="lazy" src="{{ $o['photo'] }}" alt="Foto {{ $o['role'] }}">
          </div>
          <figcaption class="mt-4">
            <p class="font-display font-bold leading-snug text-deep">{{ $o['name'] }}</p>
            <p class="text-sm text-muted">{{ $o['role'] }}</p>
          </figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>

{{-- INFORMASI & BERITA --}}
<section id="informasi" class="section curve bg-surface">
  <div class="container-x">
    <div class="flex flex-wrap items-end justify-between gap-x-6">
      <x-section-heading class="reveal" title="Informasi & Berita" text="Kabar terbaru, pengumuman penting, dan informasi publik." />
      <a href="{{ route('berita') }}" class="btn btn-ghost mb-8 md:mb-10 hidden sm:inline-flex">Lihat Semua Berita</a>
    </div>
    <div class="grid lg:grid-cols-5 gap-8 lg:gap-10">
      <div class="lg:col-span-3"><x-news-card :item="$v['news'][0]" :featured="true" /></div>
      <div class="lg:col-span-2">
        @foreach(array_slice($v['news'], 1) as $n)<x-news-card :item="$n" />@endforeach
      </div>
    </div>
    <a href="{{ route('berita') }}" class="btn btn-ghost mt-8 w-full sm:hidden">Lihat Semua Berita</a>
  </div>
</section>

{{-- POTENSI --}}
<section id="potensi" class="section curve bg-deep text-white">
  <div class="container-x">
    <x-section-heading class="reveal" :light="true" title="Potensi Desa" text="Wisata, usaha warga, hasil bumi, dan budaya yang menjadi kekuatan desa." />
    <div class="grid grid-cols-2 md:grid-cols-3 auto-rows-[14rem] md:auto-rows-[15rem] gap-3">
      @foreach($v['potentials'] as $i => $p)
        @php
          $span = match($i) { 0 => 'col-span-2 md:row-span-2', 3 => 'col-span-2', 4 => 'col-span-2 md:col-span-1', default => '' };
        @endphp
        <article class="group relative overflow-hidden rounded-md bg-forest {{ $span }}">
          <img class="img-cover absolute inset-0" loading="lazy" src="{{ $p['image'] }}" alt="">
          <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
            <p class="text-xs text-white/80">{{ $p['category'] }}</p>
            <h3 class="mt-0.5 font-bold text-lg {{ $i === 0 ? 'sm:text-2xl' : '' }}">{{ $p['title'] }}</h3>
            <p class="mt-1 text-sm text-white/85 {{ $i === 0 ? '' : 'hidden sm:block' }}">{{ $p['text'] }}</p>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- LAYANAN & TRANSPARANSI --}}
<section id="layanan" class="section curve bg-photo text-white">
  <div class="container-x">
    <x-section-heading class="reveal" :light="true" title="Layanan & Transparansi Publik" text="Informasi terbuka bagi seluruh warga. Dokumen akan tersedia setelah diunggah oleh pemerintah desa." />
    <div class="grid sm:grid-cols-2 gap-4">
      @foreach($v['transparency'] as $t)
        <a href="{{ url($t['url']) }}" class="glass rounded-md p-5 sm:p-6 flex items-start gap-4">
          <span class="grid place-items-center size-12 shrink-0 rounded-md bg-white/15 text-[var(--light)]"><x-icon :name="$t['icon']" class="size-7"/></span>
          <span>
            <span class="block font-display font-bold text-lg">{{ $t['title'] }}</span>
            <span class="block text-sm text-white/80">{{ $t['text'] }}</span>
          </span>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- GALERI --}}
<section id="galeri" class="section curve bg-soft dots">
  <div class="container-x">
    <x-section-heading class="reveal" title="Galeri Desa" text="Potret kegiatan dan lingkungan desa." />
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1" role="group" aria-label="Filter galeri">
      <button data-filter="all" aria-pressed="true" class="btn btn-ghost shrink-0 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">Semua</button>
      @foreach($cats as $c)<button data-filter="{{ $c }}" aria-pressed="false" class="btn btn-ghost shrink-0 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">{{ $c }}</button>@endforeach
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-3">
      @foreach($v['gallery'] as $g)
        <button class="gal-item aspect-[4/3] rounded-md overflow-hidden bg-forest" data-cat="{{ $g['cat'] }}" data-full="{{ $g['src'] }}" data-alt="{{ $g['alt'] }}" aria-label="Perbesar: {{ $g['alt'] }}">
          <img class="img-cover" loading="lazy" src="{{ $g['src'] }}" alt="{{ $g['alt'] }}">
        </button>
      @endforeach
    </div>
  </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <div class="grid lg:grid-cols-2 overflow-hidden rounded-xl bg-deep text-white reveal">
      <div class="p-6 sm:p-10">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold">Kontak & Lokasi</h2>
        <ul class="mt-6 grid gap-5">
          @foreach([['pin','Alamat','address'],['phone','Telepon','phone'],['mail','Email','email'],['clock','Jam Operasional','hours']] as [$ic,$lb,$k])
            <li class="flex gap-4">
              <span class="mt-0.5 text-[var(--light)]"><x-icon :name="$ic" class="size-6"/></span>
              <div><p class="font-display font-semibold text-sm">{{ $lb }}</p><p class="text-white/80">{{ $v['contact'][$k] }}</p></div>
            </li>
          @endforeach
        </ul>
        <a href="#" class="btn btn-light mt-8 w-full sm:w-auto">Hubungi Pemerintah Desa</a>
      </div>
      <div class="relative min-h-72 lg:min-h-0 bg-forest">
        @if($v['contact']['map_embed'])
          <iframe src="{{ $v['contact']['map_embed'] }}" title="Peta lokasi kantor desa" class="absolute inset-0 size-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
          <a href="{{ $v['contact']['map_link'] }}" target="_blank" rel="noopener" class="btn btn-light !min-h-10 text-sm absolute bottom-3 left-3 shadow">Buka di Google Maps</a>
        @else
          <div class="h-full min-h-72 grid place-items-center text-center p-6 text-white/80">
            <div><x-icon name="map" class="size-8 mx-auto text-[var(--light)]"/><p class="mt-2 text-sm">Peta Google Maps akan ditampilkan di sini.</p></div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
</main>

{{-- FOOTER --}}
<footer class="bg-deep text-white">
  <div class="container-x py-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
    <div>
      <div class="flex items-center gap-2.5">
        <span class="flex rounded-md bg-white p-1.5"><img src="{{ asset($v['logo']) }}" alt="Logo {{ $v['name'] }}" class="h-8 w-auto"></span>
        <span class="font-display font-bold">{{ $v['name'] }}</span>
      </div>
      <p class="mt-4 text-white/75 max-w-xs">Website resmi pemerintah desa untuk informasi dan layanan masyarakat.</p>
    </div>
    <div><h3 class="font-bold mb-4">Tautan Cepat</h3><ul class="grid gap-2 text-white/75">
      @foreach($menu as $id => $label)<li><a class="hover:text-white inline-block py-0.5" href="#{{ $id }}">{{ $label }}</a></li>@endforeach</ul></div>
    <div><h3 class="font-bold mb-4">Informasi Publik</h3><ul class="grid gap-2 text-white/75">
      @foreach($v['transparency'] as $t)<li><a class="hover:text-white inline-block py-0.5" href="#layanan">{{ $t['title'] }}</a></li>@endforeach</ul></div>
    <div><h3 class="font-bold mb-4">Kontak</h3><ul class="grid gap-2 text-white/75">
      <li>{{ $v['contact']['address'] }}</li><li>{{ $v['contact']['phone'] }}</li><li>{{ $v['contact']['email'] }}</li></ul></div>
  </div>
  <div class="border-t border-white/15">
    <div class="container-x py-5 flex flex-wrap justify-between gap-3 text-xs text-white/70">
      <p>© {{ date('Y') }} {{ $v['name'] }}. Hak cipta dilindungi.</p>
      <p>Ini adalah proyek mata kuliah semata, kesamaan nama, alamat, dan lain-lain merupakan ketidaksengajaan</p>
      <p class="flex gap-4"><a href="#" class="hover:text-white">Kebijakan Privasi</a><a href="#" class="hover:text-white">Syarat Layanan</a></p>
    </div>
  </div>
</footer>

<dialog id="lightbox" aria-label="Pratinjau gambar">
  <button data-close class="absolute right-3 top-3 btn btn-primary !min-h-0 !p-2 size-10" aria-label="Tutup">✕</button>
  <img id="lightbox-img" class="block w-full max-h-[85vh] object-contain" src="" alt="">
</dialog>
</body>
</html>
