# Fase 4: Potensi desa dan galeri

## Baca
docs/00-KONTEKS.md, config/village.php (potentials, gallery), bagian potensi dan galeri di
resources/views/landing.blade.php, bagian galeri di resources/js/app.js

## Tujuan
Potensi desa dan galeri dikelola dari dashboard.

## Rancang
- potensi: kategori (Wisata Desa, UMKM, Pertanian, Produk Lokal, Budaya dan Tradisi), judul, deskripsi, gambar, urutan, aktif.
  Layout beranda memakai urutan (item pertama = kartu besar), jadi urutan harus bisa diatur (drag and drop).
- galeri: kategori, gambar (upload), keterangan (dipakai sebagai alt), urutan, aktif.
  Tombol filter kategori di beranda dibuat dari kategori yang ada di database.
- Upload gambar: validasi tipe (jpg, png, webp) dan ukuran maksimum, resize bila memungkinkan, simpan di storage publik.
- Seeder dari config saat ini.
- Tampilan serta perilaku filter dan lightbox tidak boleh berubah.
