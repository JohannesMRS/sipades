<?php

namespace Tests\Feature;

use App\Models\Dokumen;
use App\Models\Pembangunan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembangunanDokumenPublicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_project_public_page_uses_database_data(): void
    {
        Pembangunan::query()->create([
            'name' => 'Proyek Uji',
            'location' => 'Dusun Uji',
            'category' => 'Infrastruktur',
            'budget' => 100000000,
            'start_date' => '2026-01-01',
            'end_date' => '2026-02-01',
            'status' => 'Selesai',
            'progress' => 100,
            'source' => 'Dana Desa',
            'executor' => 'TPK',
            'description' => 'Pengujian proyek',
        ]);

        $this->get('/informasi-pembangunan')->assertOk()->assertSee('Proyek Uji');
    }

    public function test_published_documents_support_search_category_and_year_filters(): void
    {
        Dokumen::query()->create([
            'title' => 'Laporan Keuangan Uji',
            'category' => 'Laporan Keuangan',
            'year' => 2026,
            'file' => 'dokumen-publik/uji.pdf',
            'is_published' => true,
        ]);
        Dokumen::query()->create([
            'title' => 'Dokumen Draft',
            'category' => 'Lainnya',
            'year' => 2025,
            'file' => 'dokumen-publik/draft.pdf',
            'is_published' => false,
        ]);

        $this->get('/dokumen-publik?q=Keuangan')->assertOk()->assertSee('Laporan Keuangan Uji')->assertDontSee('Dokumen Draft');
        $this->get('/dokumen-publik?category=APBDes&year=2024')->assertOk()->assertSee('Dokumen Tidak Ditemukan');
    }

    public function test_project_status_controls_progress(): void
    {
        $project = Pembangunan::query()->create([
            'name' => 'Proyek Selesai',
            'location' => 'Lokasi',
            'category' => 'Fasilitas Umum',
            'budget' => 1000,
            'start_date' => '2026-01-01',
            'end_date' => '2026-02-01',
            'status' => 'Selesai',
            'progress' => 20,
        ]);

        $this->assertSame(100, $project->progress);

        $project->update(['status' => 'Akan Dilaksanakan', 'progress' => 80]);
        $this->assertSame(0, $project->progress);
    }
}
