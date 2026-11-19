<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\BeritaCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeritaPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_news_is_visible_by_slug(): void
    {
        $category = BeritaCategory::query()->create(['name' => 'Berita', 'slug' => 'berita']);
        $news = Berita::factory()->create([
            'berita_category_id' => $category->id,
            'title' => 'Berita Terbit',
            'slug' => 'berita-terbit',
            'status' => 'terbit',
            'published_at' => now()->subHour(),
        ]);

        $this->get('/berita/'.$news->slug)->assertOk()->assertSee('Berita Terbit');
    }

    public function test_draft_and_future_news_are_not_visible(): void
    {
        $category = BeritaCategory::query()->create(['name' => 'Berita', 'slug' => 'berita']);
        Berita::factory()->create([
            'berita_category_id' => $category->id,
            'slug' => 'berita-draft',
            'status' => 'draft',
            'published_at' => now()->subHour(),
        ]);
        Berita::factory()->create([
            'berita_category_id' => $category->id,
            'slug' => 'berita-masa-depan',
            'status' => 'terbit',
            'published_at' => now()->addDay(),
        ]);

        $this->get('/berita/berita-draft')->assertNotFound();
        $this->get('/berita/berita-masa-depan')->assertNotFound();
    }

    public function test_news_index_supports_search_and_category_filter(): void
    {
        $category = BeritaCategory::query()->create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);
        Berita::factory()->create([
            'berita_category_id' => $category->id,
            'title' => 'Pengumuman Pajak PBB',
            'excerpt' => 'Informasi pembayaran pajak',
            'slug' => 'pengumuman-pajak-pbb',
        ]);

        $this->get('/berita?q=PBB')->assertOk()->assertSee('Pengumuman Pajak PBB');
        $this->get('/berita?kategori=pengumuman')->assertOk()->assertSee('Pengumuman Pajak PBB');
    }
}
