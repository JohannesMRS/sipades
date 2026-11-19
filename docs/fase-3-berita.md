# Fase 3: Berita

## Baca
docs/00-KONTEKS.md, config/village.php (news), resources/views/components/news-card.blade.php,
resources/views/pages/berita.blade.php, resources/views/pages/berita-show.blade.php, routes/web.php,
bagian berita di resources/views/landing.blade.php

## Tujuan
Berita dikelola dari dashboard.

## Rancang
- Tabel kategori_berita (nama, slug) dan berita: judul, slug (unik, otomatis dari judul), kategori, ringkasan,
  isi (rich text), gambar (upload), status (draft/terbit), tanggal terbit, "disematkan" (boolean).
- Hanya berita berstatus terbit dengan tanggal terbit <= sekarang yang tampil di publik.
- Route /berita/{slug} memakai kolom slug. Pertahankan URL lama jika memungkinkan.
- Seeder memindahkan berita di config saat ini, termasuk gambar yang sudah ada di public/images.
- Beranda: 1 berita utama (yang disematkan, atau terbaru) + 3 berikutnya.
  /berita: pencarian, filter kategori, pagination (6 per halaman). Boleh dipindah ke server-side asalkan tampilan sama.
- Rich text disanitasi saat ditampilkan (cegah XSS).
- Kartu "Pengumuman" tetap memakai warna amber seperti sekarang.
