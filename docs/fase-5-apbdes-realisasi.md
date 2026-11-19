# Fase 5: APBDes, realisasi anggaran, lampiran laporan PDF

## Baca
docs/00-KONTEKS.md, config/sipades.php (bidang, years), resources/views/pages/apbdes.blade.php,
resources/views/pages/realisasi.blade.php, helper JS di resources/views/layouts/page.blade.php, routes/web.php

## Tujuan
Data keuangan dari database. Perangkat desa menginput per tahun anggaran.

## Rancang
- tahun_anggaran (tahun unik, aktif, laporan_pdf nullable), bidang (5 bidang, seeder),
  pendapatan (tahun, kelompok, nama, anggaran, realisasi),
  pembiayaan (tahun, jenis Penerimaan/Pengeluaran, nama, anggaran, realisasi),
  kegiatan (tahun, nama, bidang, anggaran, realisasi, status Belum Dimulai/Sedang Berjalan/Selesai).
- Semua nominal bigInteger. Validasi: realisasi tidak boleh melebihi anggaran. Total tidak disimpan, selalu dihitung.
- Buat satu service yang membentuk data PERSIS seperti struktur config('sipades.years') lama, supaya JavaScript di halaman
  apbdes dan realisasi tidak perlu diubah. Ganti @json(config(...)) dengan data dari service itu.
- Dropdown tahun diambil dari tahun yang ada di DB.
- Upload PDF laporan resmi per tahun anggaran (hanya PDF, maksimum 10 MB, nama file disanitasi, disimpan di storage publik).
  Di halaman Realisasi, jika PDF ada tampilkan tombol "Unduh Laporan Resmi (PDF)" di samping tombol unduh yang sudah ada.
  Jika tidak ada, tombol itu tidak tampil. Tombol CSV dan cetak yang lama tetap dipertahankan.
- Filament: input rincian lewat Repeater atau Relation Manager di dalam halaman Tahun Anggaran,
  supaya satu tahun anggaran diisi dalam satu tempat.
- Seeder memindahkan data dummy tahun 2025 dan 2026 hanya sebagai data awal yang mudah dihapus.
