<?php
// Centralized PLACEHOLDER content. Replace values later; the views read only from here.
$img = fn ($seed, $w = 800, $h = 600) => "https://picsum.photos/seed/{$seed}/{$w}/{$h}";

return [
    'name' => 'Berkah Bahagia',
    'logo' => 'images/logo.png',
    'tagline' => 'Kecamatan — Kabupaten — Provinsi',
    'images' => ['hero' => $img('desa-hero', 1200, 900), 'profile' => $img('desa-profil', 900, 700)],

    'stats' => [ // dummy values
        ['icon' => 'users', 'value' => '0.000', 'label' => 'Jumlah Penduduk'],
        ['icon' => 'home',  'value' => '000',   'label' => 'Kepala Keluarga'],
        ['icon' => 'map',   'value' => '0',     'label' => 'Dusun'],
        ['icon' => 'area',  'value' => '0,0 km²', 'label' => 'Luas Wilayah'],
    ],

    'officials' => [
        ['name' => 'Nama Kepala Desa',    'role' => 'Kepala Desa',     'photo' => $img('pejabat-1', 400, 480)],
        ['name' => 'Nama Sekretaris',     'role' => 'Sekretaris Desa', 'photo' => $img('pejabat-2', 400, 480)],
        ['name' => 'Nama Kaur Keuangan',  'role' => 'Kaur Keuangan',   'photo' => $img('pejabat-3', 400, 480)],
        ['name' => 'Nama Kasi Pelayanan', 'role' => 'Kasi Pelayanan',  'photo' => $img('pejabat-4', 400, 480)],
    ],

    'news' => [
        ['category' => 'Berita', 'date' => '1 Januari 2026', 'title' => 'Judul berita utama desa ditampilkan di sini', 'excerpt' => 'Ringkasan singkat berita sebagai contoh tampilan. Ganti dengan berita sebenarnya.', 'image' => $img('berita-1', 1000, 700), 'url' => '#'],
        ['category' => 'Pengumuman', 'date' => '1 Januari 2026', 'title' => 'Contoh judul pengumuman penting', 'excerpt' => 'Ringkasan pengumuman contoh.', 'image' => $img('berita-2', 600, 400), 'url' => '#'],
        ['category' => 'Informasi', 'date' => '1 Januari 2026', 'title' => 'Contoh judul informasi publik', 'excerpt' => 'Ringkasan informasi contoh.', 'image' => $img('berita-3', 600, 400), 'url' => '#'],
        ['category' => 'Berita', 'date' => '1 Januari 2026', 'title' => 'Contoh judul kegiatan warga', 'excerpt' => 'Ringkasan kegiatan contoh.', 'image' => $img('berita-4', 600, 400), 'url' => '#'],
    ],

    'potentials' => [
        ['category' => 'Wisata Desa', 'title' => 'Judul potensi wisata', 'text' => 'Deskripsi singkat contoh.', 'image' => $img('potensi-1')],
        ['category' => 'UMKM', 'title' => 'Judul usaha warga', 'text' => 'Deskripsi singkat contoh.', 'image' => $img('potensi-2')],
        ['category' => 'Pertanian', 'title' => 'Judul hasil pertanian', 'text' => 'Deskripsi singkat contoh.', 'image' => $img('potensi-3')],
        ['category' => 'Produk Lokal', 'title' => 'Judul produk lokal', 'text' => 'Deskripsi singkat contoh.', 'image' => $img('potensi-4')],
        ['category' => 'Budaya dan Tradisi', 'title' => 'Judul tradisi desa', 'text' => 'Deskripsi singkat contoh.', 'image' => $img('potensi-5')],
    ],

    'transparency' => [
        ['icon' => 'chart', 'title' => 'APBDes', 'text' => 'Anggaran pendapatan dan belanja desa.'],
        ['icon' => 'coins', 'title' => 'Realisasi Anggaran', 'text' => 'Penggunaan anggaran desa.'],
        ['icon' => 'build', 'title' => 'Informasi Pembangunan', 'text' => 'Program dan progres pembangunan.'],
        ['icon' => 'doc',   'title' => 'Dokumen Publik', 'text' => 'Peraturan dan dokumen terbuka.'],
    ],

    'gallery' => [
        ['cat' => 'Kegiatan',   'src' => $img('galeri-1'), 'alt' => 'Kegiatan desa'],
        ['cat' => 'Lingkungan', 'src' => $img('galeri-2'), 'alt' => 'Lingkungan desa'],
        ['cat' => 'Acara',      'src' => $img('galeri-3'), 'alt' => 'Acara warga'],
        ['cat' => 'Kegiatan',   'src' => $img('galeri-4'), 'alt' => 'Kegiatan gotong royong'],
        ['cat' => 'Lingkungan', 'src' => $img('galeri-5'), 'alt' => 'Pemandangan desa'],
        ['cat' => 'Acara',      'src' => $img('galeri-6'), 'alt' => 'Acara budaya'],
    ],

    'contact' => [ // placeholders only, no real details
        'address' => '[Alamat kantor desa]', 'phone' => '[Nomor telepon]',
        'email' => '[Email resmi desa]', 'hours' => 'Senin – Jumat, [jam operasional]',
        'map_embed' => null, // paste a Google Maps embed URL here
    ],
];
