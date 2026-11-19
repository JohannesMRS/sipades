@extends('layouts.page')
@section('title', 'Realisasi Anggaran')
@section('content')
<x-page-hero title="Realisasi Anggaran" text="Pantau penggunaan anggaran desa: berapa yang direncanakan, berapa yang sudah terpakai, dan berapa yang tersisa." />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <p class="badge badge-warn">Data contoh, bukan data resmi desa</p>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-4">
      @foreach([['area','Total Anggaran','a'],['coins','Total Realisasi','r'],['clock','Sisa Anggaran','s'],['chart','Persentase Realisasi','p']] as [$ic,$lb,$id])
        <div class="panel p-4 sm:p-5">
          <span class="text-deep"><x-icon :name="$ic" class="size-6"/></span>
          <p class="mt-3 text-sm text-muted">{{ $lb }}</p>
          <p id="s-{{ $id }}" class="font-display text-lg sm:text-2xl font-extrabold text-forest break-words"></p>
        </div>
      @endforeach
    </div>

    <div class="panel p-5 sm:p-6 mt-6">
      <h2 class="font-bold text-lg text-deep">Anggaran dan Realisasi per Bidang</h2>
      <dl class="mt-3 mb-5 grid sm:grid-cols-3 gap-2 text-sm text-muted">
        <div><dt class="font-semibold text-ink inline">Anggaran:</dt> target atau batas dana yang direncanakan.</div>
        <div><dt class="font-semibold text-ink inline">Realisasi:</dt> dana yang sudah dibayarkan.</div>
        <div><dt class="font-semibold text-ink inline">Sisa:</dt> anggaran dikurangi realisasi.</div>
      </dl>
      <div class="mb-4 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-2"><i class="size-3 rounded bg-deep"></i>Anggaran</span>
        <span class="flex items-center gap-2"><i class="size-3 rounded bg-[var(--amber)]"></i>Realisasi</span>
      </div>
      <div id="chart"></div>
    </div>

    <div class="panel p-4 sm:p-6 mt-6">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <h2 class="font-bold text-lg text-deep">Rincian Realisasi per Kegiatan</h2>
        <div class="flex gap-2">
          <button id="dl-xls" class="btn btn-ghost">Unduh Excel</button>
          <button id="dl-pdf" class="btn btn-primary">Unduh PDF</button>
          @if(count($reportPdfs) > 0)
          <a id="dl-official-pdf" href="" target="_blank" rel="noopener" class="btn btn-primary hidden">Unduh Laporan Resmi (PDF)</a>
          @endif
        </div>
      </div>
      <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <input id="f-q" type="search" class="field" placeholder="Cari nama kegiatan" aria-label="Cari nama kegiatan">
        <select id="f-b" class="field" aria-label="Filter bidang"><option value="">Semua bidang</option>@foreach($budget['bidang'] as $k => $n)<option value="{{ $k }}">{{ $n }}</option>@endforeach</select>
        <select id="f-s" class="field" aria-label="Filter status"><option value="">Semua status</option><option>Belum Dimulai</option><option>Sedang Berjalan</option><option>Selesai</option></select>
        <select id="f-y" class="field" aria-label="Tahun anggaran">@foreach(array_keys($budget['years']) as $y)<option value="{{ $y }}">{{ $y }}</option>@endforeach</select>
      </div>
      <div class="mt-5">
        <table class="rt">
          <thead><tr><th>No.</th><th>Nama Kegiatan</th><th>Bidang</th><th>Anggaran</th><th>Realisasi</th><th>Sisa</th><th>%</th><th>Status</th></tr></thead>
          <tbody id="rows"></tbody>
        </table>
        <p id="empty" class="hidden text-center text-muted py-8">Tidak ada kegiatan yang cocok dengan filter.</p>
      </div>
      <div id="pager" class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm"></div>
    </div>
  </div>
</section>
<div id="print" class="hidden print:block p-6 text-sm"></div>
@endsection

@push('scripts')
<script>
const D = @json($budget['years']), BID = @json($budget['bidang']);
const REPORT_PDFS = @json($reportPdfs);
const PER = 6, st = { p: 1 };
const badge = s => s === 'Selesai' ? 'badge' : s === 'Sedang Berjalan' ? 'badge badge-warn' : 'badge badge-gray';
const set = (id, v) => q('#' + id).textContent = v;
const yr = () => q('#f-y').value;
const acts = () => D[yr()].activities;
const filtered = () => acts().filter(x =>
  x[0].toLowerCase().includes(q('#f-q').value.trim().toLowerCase()) &&
  (!q('#f-b').value || x[1] == q('#f-b').value) && (!q('#f-s').value || x[4] === q('#f-s').value));

function summary() {
  const A = acts(), b = sum(A, x => x[2]), r = sum(A, x => x[3]);
  set('s-a', rp(b)); set('s-r', rp(r)); set('s-s', rp(b - r)); set('s-p', pc(r, b) + '%');
  q('#chart').innerHTML = bars(Object.entries(BID).map(([k, n]) => {
    const rows = A.filter(x => x[1] == k); return { l: n, b: sum(rows, x => x[2]), r: sum(rows, x => x[3]) };
  }));
}
function table() {
  const F = filtered(), pages = Math.max(1, Math.ceil(F.length / PER));
  st.p = Math.min(st.p, pages);
  const start = (st.p - 1) * PER;
  q('#rows').innerHTML = F.slice(start, start + PER).map((x, i) => `<tr>
    <td data-label="No.">${start + i + 1}</td><td data-label="Kegiatan" class="font-medium">${x[0]}</td><td data-label="Bidang">${BID[x[1]]}</td>
    <td data-label="Anggaran">${rp(x[2])}</td><td data-label="Realisasi">${rp(x[3])}</td><td data-label="Sisa">${rp(x[2] - x[3])}</td>
    <td data-label="%">${pc(x[3], x[2])}%</td><td data-label="Status"><span class="${badge(x[4])}">${x[4]}</span></td></tr>`).join('');
  q('#empty').classList.toggle('hidden', F.length > 0);
  q('#pager').innerHTML = F.length ? `<span class="text-muted">${F.length} kegiatan · halaman ${st.p} dari ${pages}</span>
    <div class="flex gap-2"><button class="btn btn-ghost !min-h-10" data-go="${st.p - 1}" ${st.p === 1 ? 'disabled style="opacity:.4"' : ''}>Sebelumnya</button>
    <button class="btn btn-ghost !min-h-10" data-go="${st.p + 1}" ${st.p === pages ? 'disabled style="opacity:.4"' : ''}>Berikutnya</button></div>` : '';
}
q('#pager').addEventListener('click', e => { const b = e.target.closest('[data-go]'); if (b && !b.disabled) { st.p = +b.dataset.go; table(); q('#rows').scrollIntoView({ block: 'center' }); } });
['f-q', 'f-b', 'f-s'].forEach(id => q('#' + id).addEventListener('input', () => { st.p = 1; table(); }));
q('#f-y').addEventListener('change', () => { st.p = 1; summary(); table(); updateOfficialPdf(); });
updateOfficialPdf();

// Download: Excel (CSV) and PDF (print dialog), using the currently filtered rows
q('#dl-xls').addEventListener('click', () => {
  const head = ['No', 'Nama Kegiatan', 'Bidang', 'Anggaran', 'Realisasi', 'Sisa Anggaran', 'Persentase (%)', 'Status'];
  const lines = filtered().map((x, i) => [i + 1, x[0], BID[x[1]], x[2], x[3], x[2] - x[3], pc(x[3], x[2]), x[4]]);
  const csv = 'sep=;\n' + [head, ...lines].map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(';')).join('\n');
  const a = document.createElement('a');
  a.href = URL.createObjectURL(new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8' }));
  a.download = `laporan-realisasi-anggaran-${yr()}.csv`; a.click(); URL.revokeObjectURL(a.href);
});
q('#dl-pdf').addEventListener('click', () => {
  const F = filtered();
  q('#print').innerHTML = `<h1 style="font-size:18px;font-weight:700">Laporan Realisasi Anggaran Desa ${yr()}</h1><p style="margin-bottom:12px">Data contoh. Dicetak ${new Date().toLocaleDateString('id-ID')}</p>
  <table style="width:100%;border-collapse:collapse;font-size:11px"><thead><tr>${['No', 'Kegiatan', 'Bidang', 'Anggaran', 'Realisasi', 'Sisa', '%', 'Status'].map(h => `<th style="border:1px solid #999;padding:4px;text-align:left">${h}</th>`).join('')}</tr></thead><tbody>
  ${F.map((x, i) => `<tr>${[i + 1, x[0], BID[x[1]], rp(x[2]), rp(x[3]), rp(x[2] - x[3]), pc(x[3], x[2]) + '%', x[4]].map(c => `<td style="border:1px solid #999;padding:4px">${c}</td>`).join('')}</tr>`).join('')}
  </tbody></table>`;
  window.print();
});
summary(); table(); updateOfficialPdf();
</script>
@endpush
