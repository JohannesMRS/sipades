@php
  $setting = \App\Models\VillageSetting::query()->find(1);
  $v = [
    'name' => $setting?->name ?: 'Desa',
    'logo' => $setting?->logo ?: 'images/logo.png',
  ];
  $menu = ['beranda' => 'Beranda', 'profil' => 'Profil Desa', 'pemerintahan' => 'Pemerintahan', 'informasi' => 'Informasi', 'potensi' => 'Potensi Desa', 'layanan' => 'Layanan Desa', 'kontak' => 'Kontak'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') — {{ $v['name'] }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header id="navbar" data-solid class="sticky top-0 z-40">
  <div class="container-x flex items-center justify-between h-16 lg:h-[4.5rem] gap-4">
    <a href="{{ url('/') }}" class="flex items-center gap-2.5" aria-label="{{ $v['name'] }}">
      <span class="flex rounded-md bg-white p-1"><img src="{{ asset($v['logo']) }}" alt="Logo {{ $v['name'] }}" class="h-8 w-auto"></span>
      <span class="brand font-display font-bold hidden sm:block">{{ $v['name'] }}</span>
    </a>
    <nav class="hidden lg:flex gap-5 xl:gap-7" aria-label="Utama">
      @foreach($menu as $id => $label)<a href="{{ url('/') }}#{{ $id }}" class="nav-link">{{ $label }}</a>@endforeach
    </nav>
    <button id="nav-toggle" class="burger lg:hidden grid place-items-center size-11 -mr-2" aria-expanded="false" aria-controls="mobile-menu" aria-label="Buka menu">
      <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <div id="mobile-menu" class="hidden lg:hidden bg-surface border-t border-[var(--line)] shadow-lg">
    <nav class="container-x py-2 grid" aria-label="Seluler">
      @foreach($menu as $id => $label)<a href="{{ url('/') }}#{{ $id }}" class="py-3.5 font-display font-medium border-b border-[var(--line)] last:border-0">{{ $label }}</a>@endforeach
    </nav>
  </div>
</header>

<main>@yield('content')</main>

<footer class="bg-deep text-white">
  <div class="container-x py-8 flex flex-wrap justify-between gap-3 text-xs text-white/70">
    <p>© {{ date('Y') }} {{ $v['name'] }}. Hak cipta dilindungi.</p>
    <a href="{{ url('/') }}" class="hover:text-white">← Kembali ke beranda</a>
  </div>
</footer>

<div id="tip" hidden></div>
<dialog id="lightbox" aria-label="Pratinjau gambar">
  <button data-close class="absolute right-3 top-3 btn btn-primary !min-h-0 !p-2 size-10" aria-label="Tutup">✕</button>
  <img id="lightbox-img" class="block w-full max-h-[85vh] object-contain" src="" alt="">
</dialog>

<script>
const rp = n => 'Rp\u00A0' + Math.round(n).toLocaleString('id-ID');
const cm = n => n >= 1e9 ? (n / 1e9).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' M' : Math.round(n / 1e6).toLocaleString('id-ID') + ' jt';
const pc = (r, b) => b ? Math.round(r / b * 1000) / 10 : 0;
const sum = (a, f) => a.reduce((s, x) => s + f(x), 0);
const q = s => document.querySelector(s);
const qa = s => [...document.querySelectorAll(s)];

// Horizontal comparison bars: g = [{l: label, b: budget, r: realization}]
const bars = g => g.map(x => `<div class="mb-5"><p class="text-sm font-semibold mb-1.5">${x.l}</p>` +
  [['Anggaran', x.b, 'bg-deep'], ['Realisasi', x.r, 'bg-[var(--amber)]']].map(([n, v, c]) =>
    `<div class="flex items-center gap-2 mb-1"><div class="flex-1 h-5 rounded bg-black/5"><div tabindex="0" data-tip="${x.l} · ${n}: ${rp(v)}" class="h-5 rounded ${c}" style="width:${v ? Math.max(2, v / x.b * 100) : 0}%"></div></div><span class="w-20 text-right text-xs text-muted">${cm(v)}</span></div>`).join('') + '</div>').join('');

// Tooltip
const tip = q('#tip');
document.addEventListener('mouseover', e => { const t = e.target.closest('[data-tip]'); if (t) { tip.textContent = t.dataset.tip; tip.hidden = false; } else tip.hidden = true; });
document.addEventListener('mousemove', e => { tip.style.left = Math.min(e.clientX + 12, innerWidth - tip.offsetWidth - 8) + 'px'; tip.style.top = e.clientY + 16 + 'px'; });
document.addEventListener('focusin', e => { const t = e.target.closest('[data-tip]'); if (!t) return; const r = t.getBoundingClientRect(); tip.textContent = t.dataset.tip; tip.hidden = false; tip.style.left = Math.max(8, r.left) + 'px'; tip.style.top = r.bottom + 8 + 'px'; });
document.addEventListener('focusout', () => tip.hidden = true);
</script>
@stack('scripts')
</body>
</html>
