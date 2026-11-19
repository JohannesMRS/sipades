# Progres

- Fase 0 (verifikasi konteks): selesai — 19 November 2026
- Fase 1 (fondasi, login, peran): selesai — 19 November 2026
- Fase 2 (pengaturan desa, statistik, kontak, perangkat desa): selesai — 19 November 2026
  - menambahkan tabel `village_settings` dan kolom `sort_order/is_active` pada `perangkat_desas`.
  - Beranda memakai View Composer yang menggabungkan database dengan fallback config, tanpa mengubah markup publik.
  - Filament menyediakan satu halaman Pengaturan Desa dan resource Perangkat Desa dengan upload foto serta reorder urutan.
  - Seeder memindahkan nama, tagline, kontak, dan daftar pejabat awal dari `config/village.php`; nilai statistik dummy disimpan sebagai 0.
  - Pengujian gabungan Fase 1 dan Fase 2 lulus: 9 test, 18 assertion.
- Fase 3 (berita): selesai — 19 November 2026
  - menambahkan kategori berita dan kolom berita: slug, ringkasan, isi, gambar, status, tanggal terbit, serta disematkan.
  - Filament menyediakan dashboard untuk kategori dan berita, dengan rich text dan upload gambar publik.
  - Publik hanya menampilkan berita berstatus terbit dengan tanggal terbit tidak mendatang.
  - `/berita` memakai pencarian, filter kategori, dan pagination database; `/berita/{slug}` memakai slug database.
  - Beranda menampilkan berita utama yang disematkan atau terbaru, diikuti berita berikutnya.
  - Isi rich text disanitasi sebelum ditampilkan dan regression Fase 1–3 lulus: 12 test, 26 assertion.
- Fase 4 (potensi desa, galeri): selesai — 19 November 2026
  - menambahkan gambar, kategori, urutan, dan status aktif pada potensi desa serta galeri.
  - Dashboard Filament menyediakan potensi dan galeri dengan upload publik, validasi gambar, serta reorder drag-and-drop.
  - Beranda mengambil potensi dan galeri aktif berurutan dari database; filter kategori dan lightbox tetap memakai struktur view lama.
  - Seeder memindahkan lima potensi dan enam item galeri dari `config/village.php` tanpa data baru.
  - Regression gabungan Fase 1–4 lulus: 16 test, 30 assertion.
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
