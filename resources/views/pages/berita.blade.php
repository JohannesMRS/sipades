@extends('layouts.page')
@section('title', 'Informasi & Berita')
@section('content')
@php
  $items = collect(config('village.news'))->map(fn ($n) => $n + ['href' => route('berita.show', Str::slug($n['title']))]);
  $cats = $items->pluck('category')->unique()->values();
@endphp
<x-page-hero title="Informasi & Berita" text="Kabar terbaru, pengumuman penting, dan informasi publik dari desa." :tabs="false" crumb="Informasi" :crumb-url="url('/') . '#informasi'" />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <input id="bq" type="search" class="field sm:max-w-md" placeholder="Cari berita" aria-label="Cari berita">
    <div class="mt-4 flex gap-2 overflow-x-auto pb-1" id="bc" role="group" aria-label="Filter kategori">
      <button data-c="" aria-pressed="true" class="btn btn-ghost shrink-0 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">Semua</button>
      @foreach($cats as $c)<button data-c="{{ $c }}" aria-pressed="false" class="btn btn-ghost shrink-0 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">{{ $c }}</button>@endforeach
    </div>

    <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
      @foreach($items as $n)
        <article class="news-item panel overflow-hidden" data-cat="{{ $n['category'] }}" data-t="{{ Str::lower($n['title'] . ' ' . $n['excerpt']) }}">
          <a href="{{ $n['href'] }}" class="group flex flex-col h-full">
            <div class="aspect-[16/10] overflow-hidden bg-soft"><img class="img-cover" loading="lazy" src="{{ $n['image'] }}" alt=""></div>
            <div class="p-5 flex flex-col gap-1.5 flex-1">
              <p class="text-xs font-semibold {{ $n['category'] === 'Pengumuman' ? 'text-[var(--warn-text)]' : 'text-forest' }}">{{ $n['category'] }} <span class="text-muted font-normal">· {{ $n['date'] }}</span></p>
              <h2 class="font-bold text-lg leading-snug group-hover:underline">{{ $n['title'] }}</h2>
              <p class="text-sm text-muted line-clamp-3">{{ $n['excerpt'] }}</p>
              <span class="link mt-auto pt-2">Baca Selengkapnya</span>
            </div>
          </a>
        </article>
      @endforeach
    </div>
    <p id="empty" class="hidden text-center text-muted py-12">Tidak ada berita yang cocok dengan pencarian atau filter Anda.</p>
    <div id="pager" class="mt-6 flex flex-wrap items-center justify-between gap-3 text-sm"></div>
  </div>
</section>
@endsection

@push('scripts')
<script>
const PER = 6, st = { p: 1, c: '', s: '' };
function render() {
  const all = qa('.news-item');
  const m = all.filter(el => (!st.c || el.dataset.cat === st.c) && (!st.s || el.dataset.t.includes(st.s)));
  const pages = Math.max(1, Math.ceil(m.length / PER));
  st.p = Math.min(st.p, pages);
  const a = (st.p - 1) * PER;
  all.forEach(el => el.classList.add('hidden'));
  m.slice(a, a + PER).forEach(el => el.classList.remove('hidden'));
  q('#empty').classList.toggle('hidden', m.length > 0);
  q('#pager').innerHTML = pages > 1 ? `<span class="text-muted">${m.length} berita · halaman ${st.p} dari ${pages}</span>
    <div class="flex gap-2"><button class="btn btn-ghost !min-h-10" data-go="${st.p - 1}" ${st.p === 1 ? 'disabled style="opacity:.4"' : ''}>Sebelumnya</button>
    <button class="btn btn-ghost !min-h-10" data-go="${st.p + 1}" ${st.p === pages ? 'disabled style="opacity:.4"' : ''}>Berikutnya</button></div>` : '';
}
q('#bq').addEventListener('input', e => { st.s = e.target.value.trim().toLowerCase(); st.p = 1; render(); });
q('#bc').addEventListener('click', e => {
  const b = e.target.closest('[data-c]'); if (!b) return;
  qa('#bc button').forEach(x => x.setAttribute('aria-pressed', x === b));
  st.c = b.dataset.c; st.p = 1; render();
});
q('#pager').addEventListener('click', e => {
  const b = e.target.closest('[data-go]'); if (!b || b.disabled) return;
  st.p = +b.dataset.go; render(); window.scrollTo({ top: 0, behavior: 'smooth' });
});
render();
</script>
@endpush
