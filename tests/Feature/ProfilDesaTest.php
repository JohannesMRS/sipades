<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VillageSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilDesaTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_shows_empty_state_when_no_profile_content_exists(): void
    {
        VillageSetting::query()->create([
            'name' => 'Desa Uji',
            'area_unit' => 'km²',
        ]);

        $response = $this->get('/profil-desa');

        $response->assertOk()
            ->assertSeeText('Profil lengkap desa belum tersedia.')
            ->assertSeeText('Kembali ke Beranda')
            ->assertSeeText('Beranda')
            ->assertDontSee('picsum.photos');
    }

    public function test_profile_page_renders_only_available_content_and_sanitizes_rich_text(): void
    {
        VillageSetting::query()->create([
            'name' => 'Desa Uji',
            'tagline' => 'Tagline Uji',
            'deskripsi_singkat' => 'Profil singkat uji.',
            'foto_profil' => 'profil/desa-uji.webp',
            'sejarah' => '<p>Sejarah yang aman</p><script>alert("tidak aman")</script>',
            'visi' => 'Visi Desa Uji',
            'misi' => ['Misi pertama', '', 'Misi kedua'],
            'letak_geografis' => '<p>Letak geografis yang aman</p>',
            'batas_utara' => 'Desa Utara',
            'population' => 1234,
            'area_unit' => 'km²',
        ]);

        $response = $this->get('/profil-desa');

        $response->assertOk()
            ->assertSee('<title>Profil Desa — Desa Uji</title>', false)
            ->assertSee('content="Profil singkat uji."', false)
            ->assertSee('src="/storage/profil/desa-uji.webp"', false)
            ->assertSeeText('Profil singkat uji.')
            ->assertSeeText('Sejarah yang aman')
            ->assertSeeText('Visi Desa Uji')
            ->assertSeeText('Misi pertama')
            ->assertSeeText('Misi kedua')
            ->assertSeeText('Letak geografis yang aman')
            ->assertSeeText('Desa Utara')
            ->assertSeeText('1.234')
            ->assertDontSee('alert("tidak aman")', false)
            ->assertDontSee('picsum.photos/seed/desa-profil');
    }

    public function test_home_profile_uses_database_description_and_photo_and_only_shows_link_for_full_profile(): void
    {
        VillageSetting::query()->create([
            'name' => 'Desa Uji',
            'area_unit' => 'km²',
            'deskripsi_singkat' => 'Deskripsi singkat dari database.',
            'foto_profil' => 'profil/desa-uji.webp',
            'visi' => 'Visi Desa Uji',
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSeeText('Deskripsi singkat dari database.')
            ->assertSee('src="/storage/profil/desa-uji.webp"', false)
            ->assertSee('href="'.route('profil-desa').'"', false)
            ->assertDontSee('picsum.photos/seed/desa-profil');
    }

    public function test_home_profile_hides_full_profile_link_when_only_short_description_exists(): void
    {
        VillageSetting::query()->create([
            'name' => 'Desa Uji',
            'area_unit' => 'km²',
            'deskripsi_singkat' => 'Deskripsi singkat saja.',
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSeeText('Deskripsi singkat saja.')
            ->assertDontSeeText('Selengkapnya Tentang Desa')
            ->assertSee('src="/images/desa.jpg" alt="Suasana Desa Uji"', false);
    }

    public function test_admin_can_access_profile_fields_in_village_settings(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/village-setting');

        $response->assertOk()
            ->assertSeeText('Umum')
            ->assertSeeText('Statistik')
            ->assertSeeText('Kontak')
            ->assertSeeText('Profil')
            ->assertSeeText('Deskripsi Singkat')
            ->assertSeeText('Tampil di beranda. Tulis 2 sampai 3 kalimat.')
            ->assertSeeText('Letak Geografis')
            ->assertSee('imagePreviewHeight: "250"', false)
            ->assertSee('panelAspectRatio: "9:7"', false)
            ->assertSee('imageEditorAspectRatioOptions', false);
    }
}
