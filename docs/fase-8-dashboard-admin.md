# Fase 8: Dashboard admin kustom, ikon menu, bahasa, dan grup navigasi

## Baca
docs/00-KONTEKS.md, docs/PROGRESS.md, app/Providers/Filament/AdminPanelProvider.php (atau nama provider panel yang ada),
config/app.php, daftar isi folder app/Filament (Resources, Pages, Widgets), .env.example.
Baca juga SETIAP file Resource di app/Filament/Resources, tetapi HANYA bagian properti navigasi
(ikon, label, grup, urutan) dan metode canViewAny / policy. Jangan baca isi form dan tabel.

## Tujuan
Panel admin tidak lagi terlihat seperti Filament bawaan: dashboard sendiri yang berguna bagi perangkat desa,
ikon berbeda untuk tiap menu, teks berbahasa Indonesia, dan menu dikelompokkan dengan rapi.
Fase ini HANYA mengubah tampilan dan navigasi panel admin. Jangan mengubah halaman publik, struktur tabel,
validasi, atau logika bisnis resource.

## Masalah yang harus diperbaiki
1. Dashboard masih menampilkan widget bawaan Filament (AccountWidget "Welcome" + FilamentInfoWidget dengan link
   Documentation dan GitHub). Hapus keduanya dari panel, dan daftarkan dashboard kustom sebagai gantinya.
2. Semua menu memakai ikon yang sama. Beri ikon berbeda dan relevan per menu.
3. Label campur Inggris/Indonesia (contoh: "Budget Years"). Semua label, judul halaman, tombol, notifikasi,
   dan pesan validasi harus berbahasa Indonesia.
4. Semua menu berada di satu grup "Pengaturan Desa". Pecah menjadi grup yang sesuai (lihat di bawah).

## A. Bahasa Indonesia
- Set locale aplikasi ke "id" (APP_LOCALE di .env dan .env.example, serta fallback yang sesuai). Pastikan Carbon ikut berbahasa
  Indonesia (tanggal tampil seperti "20 November 2026").
- Terjemahan bawaan Filament sudah mendukung bahasa Indonesia; pastikan aktif. Jika ada teks yang masih Inggris
  setelah locale diganti, terjemahkan lewat file lang/id seperlunya, bukan dengan mengubah vendor.
- Tiap Resource punya: $modelLabel, $pluralModelLabel, dan $navigationLabel dalam bahasa Indonesia.
  Contoh: BudgetYear -> "Tahun Anggaran". Nama kelas, model, dan tabel TIDAK diganti; hanya label tampilan.
- Label kolom tabel, field form, dan nama aksi (Simpan, Batal, Hapus, Ubah, Buat Baru) berbahasa Indonesia.

## B. Grup navigasi dan urutan
Atur lewat $navigationGroup dan $navigationSort di tiap Resource/Page, atau lewat NavigationBuilder di panel provider.
Dashboard selalu paling atas, tanpa grup. Usulan:
- Beranda & Profil Desa: Pengaturan Desa (halaman edit tunggal, bila sudah ada), Perangkat Desa, Potensi Desa, Galeri
- Informasi: Berita, Kategori Berita
- Transparansi: Tahun Anggaran, Pembangunan, Dokumen Publik
- Pengguna: Akun Perangkat Desa (hanya terlihat oleh admin)
Aturan:
- Jika sebuah menu yang disebut di atas belum ada di project, JANGAN dibuat; cukup lewati dan laporkan.
- Grup boleh bisa dilipat. Grup "Pengguna" tidak boleh muncul sama sekali untuk operator.
- Jangan ubah slug/URL resource yang sudah ada.

## C. Ikon per menu
Gunakan set ikon yang sama dengan yang dipakai versi Filament terpasang (periksa dokumentasi versi tersebut dan pola
penulisan ikon di project; jangan menebak nama enum). Pakai gaya outline untuk menu normal. Usulan ikon (Heroicons):
- Dashboard: home
- Pengaturan Desa: cog / adjustments
- Perangkat Desa: user-group / identification
- Potensi Desa: sparkles / sun / map
- Galeri: photo
- Berita: newspaper
- Kategori Berita: tag
- Tahun Anggaran: banknotes / calculator
- Pembangunan: building-office / wrench-screwdriver
- Dokumen Publik: document-text / folder
- Akun Perangkat Desa: users / key
Syarat: setiap menu punya ikon BERBEDA. Jika ikon yang diusulkan tidak tersedia, pilih padanan terdekat yang tetap unik.
Gunakan juga ikon ini (varian solid) sebagai $activeNavigationIcon jika versi Filament mendukung.

## D. Dashboard kustom
Buat satu halaman Dashboard kustom (extends Filament Dashboard) dan ganti dashboard bawaan. Judul: "Dashboard".
Sapaan di bagian atas memakai nama pengguna yang login ("Selamat datang, [nama]") dan peran dalam bahasa Indonesia
(Admin / Operator). Tanpa logo, link, atau teks Filament di mana pun di dashboard.

Isi dashboard (semua angka dari database, tidak ada angka karangan):
1. Baris kartu ringkasan (Stats widget), maksimal 4 kartu per baris:
   - Berita terbit dan jumlah draft
   - Foto galeri
   - Proyek pembangunan: sedang berjalan
   - Dokumen publik terbit
   Tiap kartu punya ikon dan link ke daftar resource terkait.
2. Widget "Perlu Dilengkapi" (checklist otomatis, sembunyikan item yang sudah beres):
   - Statistik desa belum diisi (nilai 0 atau kosong)
   - Belum ada perangkat desa aktif
   - Tahun anggaran aktif belum punya rincian realisasi
   - Belum ada dokumen publik terbit
   - Proyek berstatus "Sedang Berjalan" yang belum diperbarui lebih dari 30 hari
   Setiap item adalah link langsung ke halaman yang perlu diisi. Jika semua beres, tampilkan pesan "Semua data sudah lengkap."
3. Widget "Aktivitas Terakhir": 5 berita terbaru (judul, status, tanggal) dengan link edit.
4. Tombol aksi cepat: "Tulis Berita", "Tambah Foto Galeri", "Perbarui Proyek", "Unggah Dokumen".
   Operator dan admin sama-sama melihatnya; aksi ke menu yang tidak boleh diakses harus otomatis tersembunyi.
5. Tautan "Lihat Website" yang membuka halaman publik di tab baru.

Aturan:
- Hormati hak akses: widget atau kartu yang mengarah ke resource yang tidak boleh dilihat peran tersebut harus tersembunyi.
- Gunakan query efisien (satu query agregat per widget, tanpa N+1). Boleh di-cache singkat (mis. 60 detik) tapi
  tidak boleh membuat angka terlihat usang setelah admin menyimpan data (invalidasi atau cache sangat pendek).
- Jika tabel kosong, tampilkan 0 atau pesan kosong yang jelas, jangan error.
- Hapus (jangan hanya disembunyikan) widget bawaan yang tidak dipakai dari daftar widget panel.

## E. Branding panel
- Nama panel "SIPADES", warna utama #166534 (forest green), font Plus Jakarta Sans atau Inter jika memungkinkan.
- Logo di brand: gunakan public/images/logo.png + nama desa (dari pengaturan desa bila sudah ada, kalau tidak ada tulis "SIPADES").
- Favicon memakai logo desa.
- Footer atau teks "Powered by Filament" tidak boleh tampil bila bisa dimatikan lewat konfigurasi resmi.
- Halaman login: ganti heading dan teks ke bahasa Indonesia, tampilkan logo desa, tanpa tautan registrasi.
- Menu pengguna (pojok kanan atas): "Profil/Ganti Password" dan "Keluar" dalam bahasa Indonesia.
- Mode gelap boleh dimatikan agar konsisten dengan identitas visual.

## Batasan
- Jangan mengubah file di resources/views/ halaman publik, resources/css/app.css, atau resources/js/app.js.
- Jangan menyentuh migrasi, model, atau seeder.
- Jangan memasang plugin Filament pihak ketiga kecuali saya setujui; jika perlu, tanyakan dulu dengan alasannya.
- Jangan mengubah kebijakan akses (policy) yang sudah ada, hanya membaca untuk menentukan visibilitas menu dan widget.

## Selesai jika
- Dashboard tidak menampilkan satu pun elemen bawaan Filament (Welcome, versi, Documentation, GitHub).
- Setiap menu di sidebar punya ikon berbeda, label Indonesia, dan berada di grup yang benar.
- Login sebagai operator: grup "Pengguna" tidak terlihat, dashboard tetap berfungsi tanpa error.
- Login sebagai admin: semua grup terlihat.
- Tidak ada teks berbahasa Inggris yang tersisa di sidebar, dashboard, halaman login, dan menu pengguna.
- Halaman publik tidak berubah sedikit pun.

## Setelah selesai
Perbarui docs/PROGRESS.md: tulis "Fase 8: selesai", plus catatan: daftar grup navigasi final, ikon yang dipakai per menu,
dan nama kelas Dashboard kustom.
