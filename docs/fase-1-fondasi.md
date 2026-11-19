# Fase 1: Fondasi (database, dashboard, login, peran)

## Baca
docs/00-KONTEKS.md, composer.json, .env.example, routes/web.php, config/app.php, app/Models/User.php

## Tujuan
Menyiapkan dasar CMS. BELUM ada tabel konten.

## Kerjakan
1. Periksa versi PHP dan Laravel saya, pilih versi Filament terbaru yang kompatibel, dan beri tahu saya sebelum memasang.
2. Konfirmasi koneksi database di .env (saya pakai PostgreSQL).
3. Pasang Filament, panel di /admin. Login saja, tanpa registrasi publik.
4. Tambah kolom role pada users ("admin" atau "operator") dan kolom aktif (boleh/tidak boleh login).
5. Resource Filament "Akun Perangkat Desa": hanya admin yang bisa melihat dan mengelolanya.
   Operator tidak boleh melihat menu ini dan tidak boleh mengakses lewat URL langsung (pakai policy).
6. Seeder satu akun admin; email dan password diambil dari .env, bukan di-hardcode.
7. Operator hanya boleh mengganti password sendiri.
8. php artisan storage:link, jelaskan kapan harus dijalankan ulang.
9. Branding panel: nama "SIPADES", warna utama #166534, logo dari public/images/logo.png.
10. Pastikan semua halaman publik masih tampil persis seperti sebelumnya.

## Selesai jika
Admin bisa login, membuat akun operator, operator bisa login tapi tidak melihat menu Akun, halaman publik tidak berubah.
