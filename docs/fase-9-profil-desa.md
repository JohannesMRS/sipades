# Fase 9: Profil desa (deskripsi, foto, dan halaman "Selengkapnya")

## Baca
docs/00-KONTEKS.md, docs/PROGRESS.md, resources/views/landing.blade.php (HANYA section #profil dan footer),
resources/views/layouts/page.blade.php, resources/views/components/page-hero.blade.php, routes/web.php,
model dan Resource Pengaturan Desa yang dibuat di Fase 2 (migrasi, model, halaman Filament-nya),
app/Providers/Filament/AdminPanelProvider.php (hanya untuk pola navigasi/ikon/grup).

## Tujuan
1. Deskripsi singkat dan foto di section "Mengenal Lebih Dekat Desa Kami" (beranda) diambil dari database dan
   bisa diedit perangkat desa lewat dashboard.
2. Tombol "Selengkapnya Tentang Desa" membuka halaman baru /profil-desa yang menampilkan profil lengkap.
Fase ini HANYA menyentuh bagian profil. Jangan mengubah section lain di beranda atau halaman layanan.

## Masalah sekarang
- Dua paragraf deskripsi di section #profil tidak tampil lagi (sebelumnya teks placeholder di Blade, bukan dari database).
- Foto profil masih gambar placeholder dari picsum.photos.
- Tombol "Selengkapnya Tentang Desa" masih href="#".

## A. Data
Tambahkan ke pengaturan desa yang sudah ada (Fase 2), JANGAN membuat tabel baru yang menduplikasi isinya,
dan JANGAN menduplikasi data yang sudah ada (luas wilayah, jumlah dusun, jumlah penduduk, alamat; pakai yang sudah ada):
- deskripsi_singkat (teks, maks 400 karakter; tampil di beranda)
- foto_profil (upload gambar; tampil di beranda dan halaman profil)
- sejarah (rich text)
- visi (teks)
- misi (daftar poin; pakai Repeater atau TagsInput, tersimpan sebagai JSON)
- letak_geografis (rich text singkat) dan batas wilayah: utara, selatan, timur, barat (teks pendek, masing-masing opsional)
Seeder/migrasi: biarkan kolom baru KOSONG. Dilarang mengisi dengan teks karangan atau menyalin placeholder
bertanda kurung siku seperti "[Deskripsi singkat desa...]" ke database.

## B. Dashboard (Filament)
- Tambahkan section/tab "Profil Desa" pada halaman edit Pengaturan Desa yang sudah ada.
  Jika halaman itu sudah terlalu panjang, pakai Tabs: "Umum", "Statistik", "Kontak", "Profil".
  Jangan membuat menu baru jika tidak perlu.
- Field: sesuai bagian A. Foto: tipe jpg/png/webp, maks 3 MB, disk 'public', direktori 'profil/', ada preview, ada image editor
  dengan rasio 9:7 (sesuai tampilan beranda).
- Beri helper text pada deskripsi singkat: "Tampil di beranda. Tulis 2 sampai 3 kalimat."
- Semua label dan teks bantuan berbahasa Indonesia.
- Hanya admin dan operator yang boleh mengedit (ikuti policy yang sudah ada).

## C. Beranda (section #profil)
- Ganti paragraf placeholder dengan deskripsi_singkat dari database.
- Foto memakai foto_profil dari database. Jika kosong, pakai /images/desa.jpg sebagai fallback (jangan picsum).
- Jika deskripsi_singkat kosong: jangan tampilkan teks placeholder ke publik. Sembunyikan paragraf saja.
- Tombol "Selengkapnya Tentang Desa" menuju route('profil-desa'). Tombol HANYA tampil jika ada minimal satu konten
  profil lengkap (sejarah, visi, misi, letak geografis, atau batas wilayah) yang terisi.
- Markup, class, urutan kolom, dan efek (border amber, posisi gambar di mobile) tidak boleh berubah.

## D. Halaman /profil-desa
- Route bernama 'profil-desa'. Pakai layouts.page dan <x-page-hero> dengan :tabs="false",
  crumb "Beranda" menuju url('/'), judul "Profil Desa", teks diambil dari nama desa + tagline.
- Konten, dengan SETIAP blok hanya tampil jika datanya terisi:
  1. Foto profil dan deskripsi singkat.
  2. Sejarah Desa (rich text, disanitasi, lebar baca max-w-prose).
  3. Visi dan Misi (visi sebagai kutipan/teks besar, misi sebagai daftar bernomor).
  4. Letak Geografis (teks + empat batas wilayah dalam grid kecil).
  5. Data Ringkas: jumlah penduduk, kepala keluarga, dusun, luas wilayah, dibaca dari pengaturan desa yang sudah ada
     (komponen .panel).
  6. Link "Lihat Perangkat Desa" menuju url('/') . '#pemerintahan'.
- Jika SEMUA blok kosong: tampilkan empty state seperti gaya halaman Dokumen Publik
  ("Profil lengkap desa belum tersedia." + tombol kembali). Jangan menampilkan teks contoh.
- Gunakan section class "section curve bg-[var(--bg)]" dan komponen/class yang sudah ada. Jangan membuat gaya baru
  kecuali benar-benar perlu, dan jika perlu tambahkan di bagian paling bawah app.css dengan komentar jelas.
- Responsif di desktop, tablet, dan HP. Teks nyaman dibaca (panjang baris < 80 karakter).
- Tambahkan "Profil Desa" ke navbar halaman layanan jika navbar tersebut memang memuat tautan beranda; ikuti pola yang ada.

## E. Navigasi dan SEO ringan
- Menu navbar "Profil Desa" di beranda tetap menggulir ke #profil. Di halaman lain tetap menuju url('/') . '#profil'.
- Judul halaman: "Profil Desa. [Nama desa]". Meta description diambil dari deskripsi singkat jika ada.

## Batasan
- Jangan mengarang isi profil, sejarah, visi, misi, atau batas wilayah.
- Jangan mengubah halaman publik lain, migrasi lama, atau model selain pengaturan desa.
- Jangan memasang paket baru kecuali benar-benar perlu; tanyakan dulu jika perlu.
- Rich text selalu disanitasi sebelum ditampilkan.

## Selesai jika
- Perangkat desa bisa mengisi deskripsi, foto, sejarah, visi, misi, dan batas wilayah dari dashboard.
- Beranda menampilkan deskripsi dan foto dari database; jika kosong tidak ada teks placeholder yang bocor ke publik.
- Tombol "Selengkapnya Tentang Desa" hanya muncul bila ada konten lengkap, dan membuka /profil-desa.
- /profil-desa tidak error saat data kosong (empty state) maupun terisi sebagian.
- Foto picsum tidak muncul lagi di bagian profil.
- Tampilan section lain di beranda tidak berubah.

## Setelah selesai
Perbarui docs/PROGRESS.md: "Fase 9: selesai", plus catatan: nama kolom baru, nama route, dan lokasi view /profil-desa.
