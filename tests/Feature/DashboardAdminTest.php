<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_custom_dashboard_and_user_navigation(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin SIPADES',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk()
            ->assertSeeText('Dashboard')
            ->assertSeeText('Selamat datang, Admin SIPADES. Peran: Admin')
            ->assertSee('sipades-dashboard-widget-card')
            ->assertSee('sipades-dashboard-actions')
            ->assertSeeText('Profil')
            ->assertSeeText('Keluar')
            ->assertSeeText('Pengguna')
            ->assertSeeText('Perlu Dilengkapi')
            ->assertSeeText('Aktivitas Terakhir')
            ->assertSeeText('Tulis Berita')
            ->assertSeeText('Tambah Foto Galeri')
            ->assertSeeText('Perbarui Proyek')
            ->assertSeeText('Unggah Dokumen')
            ->assertSeeText('Lihat Website')
            ->assertSeeText('Belum ada berita.')
            ->assertDontSee('Welcome')
            ->assertDontSee('Documentation')
            ->assertDontSee('GitHub');
    }

    public function test_operator_sees_custom_dashboard_without_user_navigation(): void
    {
        $operator = User::factory()->create([
            'name' => 'Operator SIPADES',
            'role' => 'operator',
            'is_active' => true,
        ]);

        $response = $this->actingAs($operator)->get('/admin');

        $response->assertOk()
            ->assertSeeText('Selamat datang, Operator SIPADES. Peran: Operator')
            ->assertDontSeeText('Pengguna')
            ->assertSeeText('Perlu Dilengkapi')
            ->assertSeeText('Tambahkan perangkat desa aktif');
    }

    public function test_dashboard_summary_and_recent_news_reflect_database_records(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        Berita::factory()->create([
            'title' => 'Berita Terbit Uji',
            'status' => 'terbit',
            'published_at' => '2026-11-18 08:00:00',
        ]);
        Berita::factory()->create([
            'title' => 'Berita Draf Uji',
            'status' => 'draft',
            'published_at' => null,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk()
            ->assertSeeText('Berita Terbit')
            ->assertSeeText('1 draf')
            ->assertSeeText('Berita Terbit Uji')
            ->assertSeeText('Berita Draf Uji')
            ->assertSeeText('18 November 2026');
    }

    public function test_login_page_is_indonesian_and_has_no_registration_link(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk()
            ->assertSeeText('Masuk ke akun Anda')
            ->assertSeeText('Alamat email')
            ->assertSeeText('Kata sandi')
            ->assertDontSee('buat akun baru')
            ->assertDontSee('Register');
    }
}
