# SIPADES: Konteks Proyek (BACA INI DULU, SELALU)

Website transparansi pemerintah desa, Bahasa Indonesia.
Stack: Laravel + Blade + Tailwind CSS v4 (Vite) + JavaScript biasa (tanpa framework JS).
Fase tampilan SELESAI. Fase sekarang: ganti data dummy di config/ dengan database, dan buat dashboard CMS
untuk perangkat desa.

Status tampilan publik: tersedia. Tahap implementasi database/CMS belum selesai: data publik masih bersumber dari
`config/village.php` dan `config/sipades.php`, serta dashboard CMS untuk perangkat desa belum diterapkan.

## Aturan wajib
1. JANGAN mengubah tampilan/desain halaman publik. HTML dan class yang dihasilkan harus tetap sama.
   Yang diganti hanya SUMBER DATA (dari config ke database).
2. Kerjakan HANYA fase yang saya sebut. Jangan refactor di luar lingkup dan jangan sentuh file yang tidak perlu.
3. Jangan mengarang data desa (statistik, nama pejabat, keuangan, kontak, dokumen). Seeder hanya boleh memindahkan
   isi config yang sudah ada.
4. Sebelum menulis kode: tampilkan rencana singkat (daftar file yang dibuat atau diubah) lalu TUNGGU persetujuan saya.
5. Setelah selesai: ringkas file yang berubah, perintah artisan yang harus saya jalankan, dan cara mengujinya.
   Jangan menempelkan ulang isi file panjang di chat.
6. Jangan menjalankan migrate:fresh atau perintah yang menghapus data tanpa bertanya.
7. Uang disimpan sebagai bigInteger (rupiah penuh), bukan float. Persentase selalu dihitung dinamis, tidak disimpan.
8. Pakai Eloquent, Form Request atau validasi Filament, dan eager loading (hindari N+1).
9. Setelah fase selesai, perbarui docs/PROGRESS.md (satu baris per fase, plus catatan penting).
10. Hemat konteks: baca hanya file yang disebut di bagian "Baca" pada file fase. Jangan membaca seluruh project.

## Peta file (kondisi sebelum database)
- routes/web.php: / , /apbdes , /realisasi-anggaran , /informasi-pembangunan , /dokumen-publik , /berita , /berita/{slug}
  (slug berita saat ini dihitung dari Str::slug(judul), belum ada kolom slug)
- config/village.php: name, tagline, logo, images{hero,profile}, stats[icon,value,label], officials[name,role,photo],
  news[category,date,title,excerpt,image,url,(content[])], potentials[category,title,text,image],
  transparency[icon,title,text,url], gallery[cat,src,alt],
  contact[address,phone,email,hours,map_embed,map_link]
- config/sipades.php: bidang{1..5 => nama}; years{tahun => {income:[kelompok,nama,anggaran,realisasi],
  financing:[jenis ("Penerimaan"/"Pengeluaran"),nama,anggaran,realisasi],
  activities:[nama,kode_bidang,anggaran,realisasi,status]}};
  projects[name,loc,cat,budget,start,end,status,progress,source,exec,image,desc,docs[stage,date,caption,img]]
- resources/views/landing_page.blade.php: beranda (hero, statistik, profil, pemerintahan, berita, potensi, layanan,
  galeri, kontak, footer)
- resources/views/layouts/page.blade.php: layout halaman layanan; berisi helper JS global rp(), cm(), pc(), sum(),
  q(), qa(), bars(), tooltip
- resources/views/components/: icon, section-heading, news-card, page-hero
- resources/views/pages/: apbdes, realisasi, pembangunan, dokumen, berita, berita-show
- resources/css/app.css: variabel warna + class custom (.btn, .panel, .badge, .field, .curve, .bg-photo, .dots,
  .glass, .rt, dst.)
- resources/js/app.js: navbar, scroll reveal, filter galeri + lightbox, fallback gambar
- public/images/: logo.png, desa.jpg, dan gambar lain

## Cara halaman layanan memakai data (PENTING)
Halaman pages/* menyisipkan data lewat @json(config('sipades....')) lalu dirender oleh JavaScript inline.
Saat pindah ke database: pertahankan BENTUK DATA yang sama (array of tuples / key yang sama) lewat satu class
pembentuk data (service), supaya JavaScript di view tidak perlu ditulis ulang.

## Hal yang sering bikin salah
- Tailwind v4 mereset margin <dialog>. Sudah diperbaiki di app.css, jangan dihapus.
- Komponen heading bernama section-heading.blade.php (dipanggil <x-section-heading>).
- Class .bg-soft, .text-forest, .text-deep, .text-muted adalah CSS biasa di app.css, bukan tema Tailwind.
- Halaman APBDes sengaja TANPA persentase (hanya nominal). Halaman Realisasi dan progres proyek tetap pakai persen.
- Dokumen Publik harus tetap menampilkan empty state jika tidak ada dokumen. Dilarang membuat dokumen palsu.
- Badge "Data contoh, bukan data resmi desa" di beberapa halaman dihapus setelah data asli terpasang (Fase 7).
- Unduh laporan Realisasi saat ini CSV (Excel) + window.print (PDF) dari data yang terfilter. Tetap dipertahankan.
- Gambar placeholder picsum punya fallback ke /images/desa.jpg di app.js.
- Navbar halaman layanan memakai atribut data-solid pada #navbar.

## Palet & font (jangan diubah)
#F7F6F9 bg, #FFFFFF surface, #E8F0E8 soft, #166534 forest, #18503D deep, #DCFCE7 light, #F59E0B amber,
#FEF3C7 warn-bg, #B45309 warn-text. Font: Plus Jakarta Sans (judul), Inter (isi).

## Keputusan arsitektur CMS
- Dashboard: Filament, di /admin. Hanya untuk perangkat desa. TIDAK ADA pendaftaran publik. Akun dibuat oleh admin.
- Peran: "admin" (kelola akun + semua konten) dan "operator" (hanya mengelola konten).
- Upload gambar ke storage/app/public (php artisan storage:link). Gambar lama di public/images dibiarkan.
- Upload PDF = hanya menyimpan file untuk diunduh warga. TIDAK membaca atau meng-ekstrak isi PDF.
- Di luar lingkup: data warga/penduduk per orang, pendaftaran publik, pembayaran, sistem surat-menyurat.
