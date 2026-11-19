# Fase 2: Pengaturan desa, statistik, kontak, perangkat desa

## Baca
docs/00-KONTEKS.md, config/village.php (name, tagline, logo, images, stats, officials, contact),
resources/views/landing.blade.php (hanya navbar, statistik, pemerintahan, kontak, footer)

## Tujuan
Bagian ini diambil dari database dan bisa diedit dari dashboard.

## Rancang
- Tabel pengaturan desa (satu baris): nama desa, tagline, logo, jumlah penduduk, kepala keluarga, jumlah dusun,
  luas wilayah (angka + satuan), alamat, telepon, email, jam operasional, embed peta.
  Link "Buka di Google Maps" dan embed peta dibuat otomatis dari alamat bila kolom embed kosong.
- Tabel perangkat_desa: nama, jabatan, foto (upload), urutan, aktif.
- Seeder memindahkan isi config saat ini (bukan data karangan).
- Filament: pengaturan desa berupa SATU halaman edit (bukan daftar). Perangkat desa berupa daftar yang bisa diurutkan
  (drag and drop).
- landing.blade.php dan footer membaca dari DB lewat satu View Composer atau class helper, bukan config.

## Aturan khusus
- Markup dan class HTML tidak boleh berubah.
- Jika data kosong: tampilkan "—" atau sembunyikan blok, jangan error.
- Format angka statistik tetap seperti sekarang (pemisah ribuan titik).
