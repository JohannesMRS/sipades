<?php
$img = fn ($s, $w = 800, $h = 600) => "https://picsum.photos/seed/{$s}/{$w}/{$h}";

$bidang = [
    1 => 'Penyelenggaraan Pemerintahan Desa',
    2 => 'Pelaksanaan Pembangunan Desa',
    3 => 'Pembinaan Kemasyarakatan',
    4 => 'Pemberdayaan Masyarakat',
    5 => 'Penanggulangan Bencana, Keadaan Darurat, dan Mendesak Desa',
];

// [kelompok, nama, anggaran, realisasi]
$income = [
    ['Pendapatan Asli Desa (PADes)', 'Hasil Usaha Desa', 45000000, 41500000],
    ['Pendapatan Asli Desa (PADes)', 'Swadaya dan Gotong Royong', 30000000, 27000000],
    ['Pendapatan Transfer', 'Dana Desa (DD)', 820000000, 615000000],
    ['Pendapatan Transfer', 'Alokasi Dana Desa (ADD)', 480000000, 360000000],
    ['Pendapatan Transfer', 'Bagi Hasil Pajak dan Retribusi', 65000000, 48750000],
    ['Pendapatan Transfer', 'Bantuan Keuangan Provinsi', 150000000, 90000000],
    ['Pendapatan Transfer', 'Bantuan Keuangan Kabupaten/Kota', 200000000, 120000000],
    ['Pendapatan Lain-lain', 'Pendapatan Lain-lain yang Sah', 20000000, 12000000],
];

// [jenis, nama, anggaran, realisasi]
$fin = [
    ['Penerimaan', 'Sisa Lebih Perhitungan Anggaran (SiLPA) Tahun Lalu', 120000000, 120000000],
    ['Pengeluaran', 'Penyertaan Modal BUMDes', 60000000, 60000000],
];

// [nama kegiatan, kode bidang, anggaran, realisasi, status]
$act = [
    ['Penghasilan Tetap dan Tunjangan Perangkat Desa', 1, 380000000, 285000000, 'Sedang Berjalan'],
    ['Operasional Kantor Desa', 1, 95000000, 70000000, 'Sedang Berjalan'],
    ['Tunjangan dan Operasional BPD', 1, 60000000, 45000000, 'Sedang Berjalan'],
    ['Pengembangan Sistem Informasi Desa', 1, 40000000, 0, 'Belum Dimulai'],
    ['Rehabilitasi Jalan Usaha Tani', 2, 300000000, 300000000, 'Selesai'],
    ['Pembangunan Drainase Dusun', 2, 160000000, 96000000, 'Sedang Berjalan'],
    ['Pembangunan Sarana Air Bersih', 2, 140000000, 84000000, 'Sedang Berjalan'],
    ['Pemasangan Penerangan Jalan Lingkungan', 2, 60000000, 60000000, 'Selesai'],
    ['Pembangunan Balai Pertemuan Warga', 2, 100000000, 0, 'Belum Dimulai'],
    ['Kegiatan Budaya dan Peringatan Hari Besar', 3, 60000000, 45000000, 'Sedang Berjalan'],
    ['Pembinaan Karang Taruna dan Olahraga', 3, 50000000, 30000000, 'Sedang Berjalan'],
    ['Pembinaan Keamanan dan Ketertiban (Linmas)', 3, 40000000, 24000000, 'Sedang Berjalan'],
    ['Pelatihan UMKM Warga', 4, 70000000, 42000000, 'Sedang Berjalan'],
    ['Penguatan BUMDes dan Pertanian', 4, 120000000, 72000000, 'Sedang Berjalan'],
    ['Posyandu dan Pemberian Makanan Tambahan', 4, 50000000, 50000000, 'Selesai'],
    ['Bantuan Operasional PAUD', 4, 40000000, 0, 'Belum Dimulai'],
    ['Bantuan Langsung Tunai Dana Desa', 5, 80000000, 60000000, 'Sedang Berjalan'],
    ['Kesiapsiagaan dan Penanganan Bencana', 5, 25000000, 10000000, 'Sedang Berjalan'],
];

// Tahun sebelumnya dibuat dari tahun berjalan (skala + realisasi hampir penuh)
$prev = fn ($rows, $f, $rf, $done = false) => array_map(function ($x) use ($f, $rf, $done) {
    $x[2] = (int) round($x[2] * $f, -6);
    $x[3] = (int) round($x[2] * $rf, -5);
    if ($done) $x[4] = 'Selesai';
    return $x;
}, $rows);

$doc = fn ($s, $stage, $date, $cap) => ['stage' => $stage, 'date' => $date, 'caption' => $cap, 'img' => $img($s)];

return [
    'bidang' => $bidang,
    'years' => [
        2026 => ['income' => $income, 'financing' => $fin, 'activities' => $act],
        2025 => ['income' => $prev($income, .92, .97), 'financing' => $prev($fin, .92, 1), 'activities' => $prev($act, .92, .985, true)],
    ],
    'projects' => [
        ['name' => 'Rehabilitasi Jalan Usaha Tani', 'loc' => 'Dusun [nama dusun]', 'cat' => 'Infrastruktur', 'budget' => 300000000,
         'start' => '2026-02-02', 'end' => '2026-05-29', 'status' => 'Selesai', 'progress' => 100, 'source' => 'Dana Desa (DD)',
         'exec' => 'Tim Pelaksana Kegiatan (TPK) Desa', 'image' => $img('proyek-jalan', 900, 600),
         'desc' => 'Perbaikan jalan menuju lahan pertanian agar hasil panen lebih mudah diangkut. [Deskripsi contoh, ganti dengan data sebenarnya.]',
         'docs' => [$doc('jalan-1', 'Sebelum', '2026-01-26', 'Kondisi jalan sebelum diperbaiki'), $doc('jalan-2', 'Proses', '2026-03-16', 'Pengerasan badan jalan'), $doc('jalan-3', 'Setelah', '2026-05-29', 'Jalan selesai dan dapat dilalui')]],
        ['name' => 'Pemasangan Penerangan Jalan Lingkungan', 'loc' => 'Dusun [nama dusun]', 'cat' => 'Fasilitas Umum', 'budget' => 60000000,
         'start' => '2026-03-02', 'end' => '2026-04-17', 'status' => 'Selesai', 'progress' => 100, 'source' => 'Alokasi Dana Desa (ADD)',
         'exec' => 'Tim Pelaksana Kegiatan (TPK) Desa', 'image' => $img('proyek-lampu', 900, 600),
         'desc' => 'Pemasangan lampu jalan di titik rawan gelap. [Deskripsi contoh.]',
         'docs' => [$doc('lampu-1', 'Sebelum', '2026-02-25', 'Titik lokasi sebelum dipasang'), $doc('lampu-2', 'Setelah', '2026-04-17', 'Lampu jalan menyala')]],
        ['name' => 'Pembangunan Drainase Dusun', 'loc' => 'Dusun [nama dusun]', 'cat' => 'Sanitasi', 'budget' => 160000000,
         'start' => '2026-08-03', 'end' => '2026-12-18', 'status' => 'Sedang Berjalan', 'progress' => 60, 'source' => 'Dana Desa (DD)',
         'exec' => 'Tim Pelaksana Kegiatan (TPK) Desa', 'image' => $img('proyek-drainase', 900, 600),
         'desc' => 'Saluran air untuk mengurangi genangan saat hujan. [Deskripsi contoh.]',
         'docs' => [$doc('drain-1', 'Sebelum', '2026-07-27', 'Lokasi sebelum penggalian'), $doc('drain-2', 'Proses', '2026-10-05', 'Pemasangan pasangan batu')]],
        ['name' => 'Pembangunan Sarana Air Bersih', 'loc' => 'Dusun [nama dusun]', 'cat' => 'Sanitasi', 'budget' => 140000000,
         'start' => '2026-09-01', 'end' => '2027-01-29', 'status' => 'Sedang Berjalan', 'progress' => 60, 'source' => 'Alokasi Dana Desa (ADD)',
         'exec' => 'Tim Pelaksana Kegiatan (TPK) Desa', 'image' => $img('proyek-air', 900, 600),
         'desc' => 'Penyediaan jaringan air bersih untuk warga. [Deskripsi contoh.]',
         'docs' => [$doc('air-1', 'Sebelum', '2026-08-25', 'Sumber air sebelum dikelola'), $doc('air-2', 'Proses', '2026-10-20', 'Pemasangan pipa utama')]],
        ['name' => 'Pembangunan Balai Pertemuan Warga', 'loc' => 'Dusun [nama dusun]', 'cat' => 'Fasilitas Umum', 'budget' => 100000000,
         'start' => '2026-12-01', 'end' => '2027-02-26', 'status' => 'Akan Dilaksanakan', 'progress' => 0, 'source' => 'Bantuan Keuangan Kabupaten/Kota',
         'exec' => 'Tim Pelaksana Kegiatan (TPK) Desa', 'image' => $img('proyek-balai', 900, 600),
         'desc' => 'Balai untuk musyawarah dan kegiatan warga. [Deskripsi contoh.]', 'docs' => []],
    ],
];
