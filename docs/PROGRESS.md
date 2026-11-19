# Progres

- Fase 0 (verifikasi konteks): selesai — 19 November 2026
- Fase 1 (fondasi, login, peran): selesai — 19 November 2026
- Fase 2 (pengaturan desa, statistik, kontak, perangkat desa): belum
- Fase 3 (berita): belum
- Fase 4 (potensi desa, galeri): belum
- Fase 5 (APBDes, realisasi, lampiran laporan PDF): belum
- Fase 6 (informasi pembangunan, dokumen publik): belum
- Fase 7 (pembersihan, keamanan, test): belum

## Catatan penting dari fase sebelumnya
- Lingkungan aktual: PHP 8.5.4, Laravel 13.40.0, Tailwind CSS 4.3.5, Vite 8.3.8.
- Beranda memakai `resources/views/landing_page.blade.php`, bukan `landing.blade.php`.
- Data publik masih bersumber dari `config/village.php` dan `config/sipades.php`; database domain baru belum diimplementasikan.
- Filament v5.11.4 terpasang dengan panel `/admin`; Laravel runtime diperbarui oleh Composer menjadi v13.43.0.
- PostgreSQL adalah database aplikasi; SQLite hanya digunakan oleh konfigurasi PHPUnit in-memory.
- Migrasi `users` menambahkan `role` dan `is_active`; akun admin dibuat melalui `AdminSeeder` dari variabel `.env`.
- Policy membatasi Akun Perangkat Desa untuk admin; operator dapat mengubah profil/password sendiri melalui panel.
- Panel dibedakan merek SIPADES, warna primer #166534, dan logo `public/images/logo.png`.
- `public/storage` telah terhubung dengan `storage/app/public`.
- Pengujian `UserPolicyTest` lulus: 5 test, 13 assertion; halaman publik `/` tetap berhasil HTTP 200.
