@extends('layouts.page')
@section('title', 'APBDes')
@section('content')
<x-page-hero title="APBDes" text="Anggaran Pendapatan dan Belanja Desa: dari mana dana desa berasal dan untuk apa dana tersebut digunakan." />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <div class="flex justify-end mb-4">
      <label class="flex items-center gap-2 text-sm font-semibold">Tahun anggaran
        <select id="year" class="field !w-auto">@foreach(array_keys(config('sipades.years')) as $y)<option>{{ $y }}</option>@endforeach</select>
      </label>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
      @foreach([['coins','Total Pendapatan','inc'],['build','Total Belanja','exp'],['chart','Pembiayaan (Netto)','fin'],['area','Total Anggaran','all']] as [$ic,$lb,$id])
        <div class="panel p-4 sm:p-5">
          <span class="text-deep"><x-icon :name="$ic" class="size-6"/></span>
          <p class="mt-3 text-sm text-muted">{{ $lb }}</p>
          <p id="s-{{ $id }}" class="font-display text-lg sm:text-2xl font-extrabold text-forest break-words"></p>
          <p id="n-{{ $id }}" class="text-xs text-muted"></p>
        </div>
      @endforeach
    </div>

    <div class="panel p-5 sm:p-6 mt-6">
      <h2 class="font-bold text-lg text-deep">Realisasi Anggaran</h2>
      <dl class="mt-5 grid sm:grid-cols-3 gap-5">
        <div><dt class="text-sm text-muted">Dianggarkan</dt><dd id="d-b" class="font-display text-xl sm:text-2xl font-extrabold text-deep break-words"></dd></div>
        <div><dt class="text-sm text-muted">Terealisasi</dt><dd id="d-r" class="font-display text-xl sm:text-2xl font-extrabold text-forest break-words"></dd></div>
        <div><dt class="text-sm text-muted">Sisa anggaran</dt><dd id="d-s" class="font-display text-xl sm:text-2xl font-extrabold text-[var(--warn-text)] break-words"></dd></div>
      </dl>
    </div>

    <div class="panel p-5 sm:p-6 mt-6">
      <h2 class="font-bold text-lg text-deep">Perbandingan Anggaran dan Realisasi</h2>
      <div class="mt-2 mb-5 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-2"><i class="size-3 rounded bg-deep"></i>Anggaran</span>
        <span class="flex items-center gap-2"><i class="size-3 rounded bg-[var(--amber)]"></i>Realisasi</span>
      </div>
      <div id="chart"></div>
    </div>

    <div class="mt-10"><h2 class="text-xl sm:text-2xl font-bold text-deep">Rincian Pendapatan Desa</h2><div id="income" class="mt-4"></div></div>
    <div class="mt-10"><h2 class="text-xl sm:text-2xl font-bold text-deep">Rincian Belanja Desa</h2><div id="expense" class="mt-4"></div></div>
  </div>
</section>
@endsection

@push('scripts')
<script>
const D = @json(config('sipades.years')), BID = @json(config('sipades.bidang'));
const hdr = `<div class="hidden sm:grid grid-cols-[1fr_11rem_11rem] gap-x-4 text-xs font-semibold text-muted pb-2"><span>Uraian</span><span>Anggaran</span><span>Realisasi</span></div>`;
const row = (n, b, r, strong) => `<div class="grid sm:grid-cols-[1fr_11rem_11rem] gap-x-4 gap-y-1 py-3 border-t border-[var(--line)] items-center ${strong ? 'font-bold' : ''}">
  <p class="${strong ? '' : 'font-medium'}">${n}</p>
  <p class="text-sm"><span class="sm:hidden text-muted font-normal">Anggaran: </span>${rp(b)}</p>
  <p class="text-sm"><span class="sm:hidden text-muted font-normal">Realisasi: </span>${rp(r)}</p></div>`;
const set = (id, v) => q('#' + id).textContent = v;

function draw(y) {
  const d = D[y], I = d.income, F = d.financing, A = d.activities;
  const ib = sum(I, x => x[2]), ir = sum(I, x => x[3]);
  const eb = sum(A, x => x[2]), er = sum(A, x => x[3]);
  const fs = t => [sum(F.filter(x => x[0] === t), x => x[2]), sum(F.filter(x => x[0] === t), x => x[3])];
  const [pb, pr] = fs('Penerimaan'), [kb, kr] = fs('Pengeluaran');
  const fb = pb - kb, fr = pr - kr;
  const ab = eb + kb, ar = er + kr;

  set('s-inc', rp(ib)); set('n-inc', `Realisasi ${rp(ir)}`);
  set('s-exp', rp(eb)); set('n-exp', `Realisasi ${rp(er)}`);
  set('s-fin', rp(fb)); set('n-fin', `Penerimaan ${cm(pb)} − pengeluaran ${cm(kb)}`);
  set('s-all', rp(ab)); set('n-all', 'Belanja + pengeluaran pembiayaan');
  set('d-b', rp(ab)); set('d-r', rp(ar)); set('d-s', rp(ab - ar));
  q('#chart').innerHTML = bars([{ l: 'Pendapatan', b: ib, r: ir }, { l: 'Belanja', b: eb, r: er }, { l: 'Pembiayaan (netto)', b: fb, r: fr }]);

  const groups = [...new Set(I.map(x => x[0]))];
  q('#income').innerHTML = groups.map(g => {
    const rows = I.filter(x => x[0] === g);
    return `<div class="panel p-4 sm:p-6 mb-4"><h3 class="font-bold text-deep mb-3">${g}</h3>${hdr}${rows.map(x => row(x[1], x[2], x[3])).join('')}${row('Jumlah', sum(rows, x => x[2]), sum(rows, x => x[3]), true)}</div>`;
  }).join('');

  q('#expense').innerHTML = `<div class="panel p-4 sm:p-6">${hdr}` + Object.entries(BID).map(([k, n]) => {
    const rows = A.filter(x => x[1] == k);
    return row(n, sum(rows, x => x[2]), sum(rows, x => x[3]));
  }).join('') + row('Jumlah Belanja', eb, er, true) + '</div>';
}
q('#year').addEventListener('change', e => draw(e.target.value));
draw(q('#year').value);
</script>
@endpush
