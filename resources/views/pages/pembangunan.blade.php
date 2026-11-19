@extends('layouts.page')
@section('title', 'Informasi Pembangunan')
@section('content')
<x-page-hero title="Informasi Pembangunan" text="Proyek pembangunan desa yang sudah selesai, sedang berjalan, dan akan dilaksanakan." />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-4">
      @foreach([['build','Total Proyek','t'],['doc','Proyek Selesai','d'],['clock','Sedang Berjalan','r'],['map','Akan Dilaksanakan','p']] as [$ic,$lb,$id])
        <div class="panel p-4 sm:p-5">
          <span class="text-deep"><x-icon :name="$ic" class="size-6"/></span>
          <p class="mt-3 text-sm text-muted">{{ $lb }}</p>
          <p id="s-{{ $id }}" class="font-display text-2xl sm:text-3xl font-extrabold text-forest"></p>
        </div>
      @endforeach
    </div>

    <div class="mt-8 flex gap-2 overflow-x-auto pb-1" id="tabs" role="group" aria-label="Filter status">
      @foreach(['' => 'Semua', 'Selesai' => 'Selesai', 'Sedang Berjalan' => 'Sedang Berjalan', 'Akan Dilaksanakan' => 'Akan Dilaksanakan'] as $val => $lb)
        <button data-s="{{ $val }}" aria-pressed="{{ $val === '' ? 'true' : 'false' }}" class="btn btn-ghost shrink-0 aria-pressed:!bg-[var(--forest)] aria-pressed:!text-white">{{ $lb }}</button>
      @endforeach
    </div>
    <div id="list" class="mt-5 grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5"></div>
  </div>
</section>

<dialog id="proyek" aria-label="Detail proyek"><div id="detail"></div></dialog>
@endsection

@push('scripts')
<script>
const P = @json($projects);
const dt = s => new Date(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
const badge = s => s === 'Selesai' ? 'badge' : s === 'Sedang Berjalan' ? 'badge badge-warn' : 'badge badge-gray';
const set = (id, v) => q('#' + id).textContent = v;
set('s-t', P.length); set('s-d', P.filter(p => p.status === 'Selesai').length);
set('s-r', P.filter(p => p.status === 'Sedang Berjalan').length); set('s-p', P.filter(p => p.status === 'Akan Dilaksanakan').length);
const prog = p => `<div class="h-2.5 rounded-full bg-black/10 overflow-hidden"><div class="h-2.5 bg-forest" style="width:${p}%"></div></div>`;

function list(f) {
  q('#list').innerHTML = P.map((p, i) => ({ p, i })).filter(({ p }) => !f || p.status === f).map(({ p, i }) => `
  <button data-i="${i}" class="group panel overflow-hidden text-left flex flex-col hover:border-[var(--forest)] transition-colors">
    <div class="aspect-[16/10] overflow-hidden bg-soft"><img class="img-cover" loading="lazy" src="${p.image}" alt="Foto ${p.name}"></div>
    <div class="p-5 flex flex-col gap-2 flex-1">
      <div class="flex items-center justify-between gap-2"><span class="${badge(p.status)}">${p.status}</span><span class="text-xs text-muted">${p.cat}</span></div>
      <h3 class="font-bold text-lg leading-snug">${p.name}</h3>
      <p class="text-sm text-muted">${p.loc}</p>
      <p class="text-sm"><span class="text-muted">Anggaran:</span> <b>${rp(p.budget)}</b></p>
      <p class="text-xs text-muted">${dt(p.start)} – ${dt(p.end)}</p>
      ${p.status === 'Sedang Berjalan' ? `<div class="mt-1"><div class="flex justify-between text-xs mb-1"><span>Progres</span><b>${p.progress}%</b></div>${prog(p.progress)}</div>` : ''}
    </div></button>`).join('') || '<p class="text-muted">Belum ada proyek pada status ini.</p>';
}
q('#tabs').addEventListener('click', e => { const b = e.target.closest('[data-s]'); if (!b) return; qa('#tabs button').forEach(x => x.setAttribute('aria-pressed', x === b)); list(b.dataset.s); });

const dlg = q('#proyek');
q('#list').addEventListener('click', e => {
  const b = e.target.closest('[data-i]'); if (!b) return;
  const p = P[b.dataset.i];
  const stages = [['Sebelum', 'Sebelum pembangunan'], ['Proses', 'Proses pembangunan'], ['Setelah', 'Setelah pembangunan']];
  const info = [['Lokasi', p.loc], ['Total dana', rp(p.budget)], ['Sumber dana', p.source], ['Pelaksana', p.exec], ['Tanggal mulai', dt(p.start)], ['Estimasi selesai', dt(p.end)], ['Status', p.status], ['Bidang', p.cat]];
  q('#detail').innerHTML = `
  <div class="aspect-[16/8] bg-soft"><img class="img-cover" src="${p.image}" alt="Foto ${p.name}"></div>
  <button data-x class="absolute right-3 top-3 btn btn-primary !min-h-0 !p-2 size-10" aria-label="Tutup">✕</button>
  <div class="p-5 sm:p-8">
    <span class="${badge(p.status)}">${p.status}</span>
    <h2 class="mt-2 text-2xl font-bold text-deep">${p.name}</h2>
    <p class="mt-2 text-muted">${p.desc}</p>
    <dl class="mt-5 grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">${info.map(([k, v]) => `<div><dt class="text-muted">${k}</dt><dd class="font-semibold">${v}</dd></div>`).join('')}</dl>
    <div class="mt-5"><div class="flex justify-between text-sm mb-1"><span class="text-muted">Persentase progres</span><b>${p.progress}%</b></div>${prog(p.progress)}</div>
    <h3 class="mt-8 text-lg font-bold text-deep">Dokumentasi Progres</h3>
    ${p.docs.length ? stages.map(([k, label]) => { const d = p.docs.filter(x => x.stage === k); return d.length ? `<h4 class="mt-4 mb-2 text-sm font-semibold">${label}</h4><div class="grid grid-cols-2 sm:grid-cols-3 gap-3">${d.map(x => `
      <figure><button data-full="${x.img}" data-alt="${x.caption}" class="block w-full aspect-[4/3] overflow-hidden rounded-md bg-soft group" aria-label="Perbesar: ${x.caption}"><img class="img-cover" loading="lazy" src="${x.img}" alt="${x.caption}"></button>
      <figcaption class="mt-1 text-xs"><span class="text-muted">${dt(x.date)}</span><br>${x.caption}</figcaption></figure>`).join('')}</div>` : ''; }).join('')
      : '<p class="mt-2 text-sm text-muted">Dokumentasi belum tersedia karena proyek belum dimulai.</p>'}
  </div>`;
  dlg.showModal();
});
dlg.addEventListener('click', e => {
  if (e.target === dlg || e.target.closest('[data-x]')) return dlg.close();
  const f = e.target.closest('[data-full]');
  if (f) { q('#lightbox-img').src = f.dataset.full; q('#lightbox-img').alt = f.dataset.alt; q('#lightbox').showModal(); }
});
list('');
</script>
@endpush
