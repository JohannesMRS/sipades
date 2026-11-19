# Fase 6: Informasi pembangunan dan dokumen publik

## Baca
docs/00-KONTEKS.md, config/sipades.php (projects), resources/views/pages/pembangunan.blade.php,
resources/views/pages/dokumen.blade.php, routes/web.php

## Tujuan
Proyek pembangunan dan dokumen publik dikelola dari dashboard.

## Rancang
- proyek: nama, lokasi, bidang/kategori, anggaran, tanggal mulai, estimasi selesai,
  status (Selesai/Sedang Berjalan/Akan Dilaksanakan), progres 0 sampai 100, sumber dana, pelaksana, deskripsi, gambar utama.
  Validasi: progres 100 jika Selesai, 0 jika Akan Dilaksanakan.
- dokumentasi_proyek: proyek, tahap (Sebelum/Proses/Setelah), tanggal, keterangan, foto. Dikelola sebagai Relation Manager.
- Bentuk data untuk JavaScript di halaman pembangunan HARUS sama dengan struktur config projects yang lama (lewat service).
- dokumen_publik: judul, kategori, tahun, file (PDF saja; opsional DOC/XLS), deskripsi, terbit/tidak.
  File tidak dibaca isinya, hanya disimpan dan diunduh.
  Halaman publik: pencarian, filter kategori dan tahun yang BENAR-BENAR memfilter data, serta tombol unduh.
  Jika belum ada dokumen terbit, tampilkan empty state yang sekarang. Jangan membuat dokumen contoh.
- Unduhan lewat route yang aman (nama file asli tetap, tipe MIME benar). Jumlah unduhan boleh dicatat (opsional).
- Kartu layanan di beranda (transparency) tidak perlu CMS; cukup tetap dari config atau konstanta.
