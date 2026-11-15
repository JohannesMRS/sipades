@extends('layouts.page')
@section('title', 'Dokumen Publik')
@section('content')
<x-page-hero title="Dokumen Publik" text="Tempat warga mencari dan mengunduh dokumen resmi pemerintah desa, seperti peraturan desa, laporan keuangan, dan rencana kerja." />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <div class="grid sm:grid-cols-3 gap-3">
      <input id="dq" type="search" class="field sm:col-span-1" placeholder="Cari dokumen" aria-label="Cari dokumen">
      <select id="dc" class="field" aria-label="Kategori dokumen">
        <option value="">Semua kategori</option>
        @foreach(['Peraturan Desa', 'APBDes', 'Laporan Keuangan', 'RPJMDes dan RKPDes', 'Laporan Kinerja', 'Lainnya'] as $c)<option>{{ $c }}</option>@endforeach
      </select>
      <select id="dy" class="field" aria-label="Tahun">
        <option value="">Semua tahun</option>
        @foreach([2026, 2025, 2024] as $y)<option>{{ $y }}</option>@endforeach
      </select>
    </div>

    <div class="panel mt-6 px-6 py-16 text-center">
      <span class="mx-auto grid place-items-center size-20 rounded-full bg-light text-deep"><x-icon name="doc" class="size-10"/></span>
      <h2 id="et" class="mt-6 text-2xl font-bold text-deep">Belum Ada Dokumen</h2>
      <p id="ep" class="mt-2 mx-auto max-w-md text-muted">Dokumen publik desa belum tersedia saat ini. Silakan kunjungi kembali halaman ini untuk mendapatkan informasi dan dokumen terbaru.</p>
      <a href="{{ url('/') }}#layanan" class="btn btn-ghost mt-6">Kembali ke Layanan Desa</a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
const upd = () => {
  const f = q('#dq').value.trim() || q('#dc').value || q('#dy').value;
  q('#et').textContent = f ? 'Dokumen Tidak Ditemukan' : 'Belum Ada Dokumen';
  q('#ep').textContent = f ? 'Belum ada dokumen yang cocok dengan pencarian atau filter Anda. Coba ubah kata kunci atau pilih "Semua".'
    : 'Dokumen publik desa belum tersedia saat ini. Silakan kunjungi kembali halaman ini untuk mendapatkan informasi dan dokumen terbaru.';
};
['dq', 'dc', 'dy'].forEach(id => q('#' + id).addEventListener('input', upd));
</script>
@endpush
