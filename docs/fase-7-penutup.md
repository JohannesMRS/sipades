# Fase 7: Pembersihan, keamanan, test

## Baca
docs/00-KONTEKS.md, docs/PROGRESS.md, dan hasil pencarian teks config('village dan config('sipades di seluruh project

## Kerjakan
1. Pastikan tidak ada lagi view yang membaca data konten dari config/village.php atau config/sipades.php.
   Pindahkan sisanya ke DB atau konstanta. Usulkan penghapusan file config dummy dan tunggu persetujuan.
2. Hapus badge "Data contoh, bukan data resmi desa" dan teks placeholder yang sudah tidak relevan.
3. Performa: eager loading, index pada kolom yang dipakai filter dan urutan, cache data yang jarang berubah
   (invalidasi saat admin menyimpan).
4. Keamanan: /admin hanya untuk akun aktif, policy per peran, validasi upload (tipe, ukuran, nama file),
   sanitasi rich text, pembatasan percobaan login, APP_DEBUG=false untuk produksi.
5. Backup: jelaskan cara mem-backup database dan folder storage/app/public.
6. Test sederhana (Pest atau PHPUnit): halaman publik tidak error saat data kosong, berita draft tidak tampil,
   realisasi tidak boleh melebihi anggaran, operator tidak bisa membuka halaman Akun.
7. Laporkan checklist yang belum beres.
