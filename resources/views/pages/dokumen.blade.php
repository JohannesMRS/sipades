@extends('layouts.page')
@section('title', 'Dokumen Publik')
@section('content')
<x-page-hero title="Dokumen Publik" text="Tempat warga mencari dan mengunduh dokumen resmi pemerintah desa, seperti peraturan desa, laporan keuangan, dan rencana kerja." />

<section class="section curve bg-[var(--bg)]">
  <div class="container-x">
    <div class="grid sm:grid-cols-3 gap-3">
      <input id="dq" type="search" value="{{ $search }}" class="field sm:col-span-1" placeholder="Cari dokumen" aria-label="Cari dokumen">
      <select id="dc" class="field" aria-label="Kategori dokumen">
        <option value="">Semua kategori</option>
        @foreach($categories as $c)<option value="{{ $c }}" @selected($category === $c)>{{ $c }}</option>@endforeach
      </select>
      <select id="dy" class="field" aria-label="Tahun">
        <option value="">Semua tahun</option>
        @foreach($years as $y)<option value="{{ $y }}" @selected($year === (string) $y)>{{ $y }}</option>@endforeach
      </select>
    </div>

    @if($documents->isNotEmpty())
      <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @foreach($documents as $dokumen)
          <article class="panel p-5 flex flex-col gap-3">
            <div class="flex items-center gap-3">
              <span class="grid place-items-center size-12 rounded-md bg-light text-deep"><x-icon name="doc" class="size-6"/></span>
              <div><p class="text-xs text-muted">{{ $dokumen->category }} · {{ $dokumen->year }}</p><h2 class="font-bold leading-snug text-deep">{{ $dokumen->title }}</h2></div>
            </div>
            @if($dokumen->description)<p class="text-sm text-muted line-clamp-3">{{ $dokumen->description }}</p>@endif
            <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-primary mt-auto">Unduh Dokumen</a>
          </article>
        @endforeach
      </div>
    @else
      <div class="panel mt-6 px-6 py-16 text-center">
        <span class="mx-auto grid place-items-center size-20 rounded-full bg-light text-deep"><x-icon name="doc" class="size-10"/></span>
        <h2 id="et" class="mt-6 text-2xl font-bold text-deep">{{ $search || $category || $year ? 'Dokumen Tidak Ditemukan' : 'Belum Ada Dokumen' }}</h2>
        <p id="ep" class="mt-2 mx-auto max-w-md text-muted">{{ $search || $category || $year ? 'Belum ada dokumen yang cocok dengan pencarian atau filter Anda. Coba ubah kata kunci atau pilih "Semua".' : 'Dokumen publik desa belum tersedia saat ini. Silakan kunjungi kembali halaman ini untuk mendapatkan informasi dan dokumen terbaru.' }}</p>
        <a href="{{ url('/') }}#layanan" class="btn btn-ghost mt-6">Kembali ke Layanan Desa</a>
      </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script>
let searchTimer;
const applyDocumentFilter = () => {
  const params = new URLSearchParams();
  const search = q('#dq').value.trim();
  const category = q('#dc').value;
  const year = q('#dy').value;
  if (search) params.set('q', search);
  if (category) params.set('category', category);
  if (year) params.set('year', year);
  const query = params.toString();
  window.location.assign('{{ route('dokumen') }}' + (query ? '?' + query : ''));
};
q('#dq').addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(applyDocumentFilter, 500); });
q('#dc').addEventListener('change', applyDocumentFilter);
q('#dy').addEventListener('change', applyDocumentFilter);
</script>
@endpush
