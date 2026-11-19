<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\PotensiDesa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PotensiGalleryTest extends TestCase
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

    public function test_active_potentials_are_ordered(): void
    {
        PotensiDesa::query()->create(['title' => 'Potensi B', 'type' => 'umkm', 'category' => 'UMKM', 'description' => 'B', 'sort_order' => 2, 'is_active' => true]);
        PotensiDesa::query()->create(['title' => 'Potensi A', 'type' => 'wisata desa', 'category' => 'Wisata Desa', 'description' => 'A', 'sort_order' => 1, 'is_active' => true]);
        PotensiDesa::query()->create(['title' => 'Tersembunyi', 'type' => 'umkm', 'category' => 'UMKM', 'description' => 'C', 'sort_order' => 0, 'is_active' => false]);

        $titles = PotensiDesa::query()->activeOrdered()->pluck('title')->all();

        $this->assertSame(['Potensi A', 'Potensi B'], $titles);
    }

    public function test_gallery_categories_and_active_order_are_available(): void
    {
        Gallery::query()->create(['category' => 'Kegiatan', 'image' => 'galeri/a.jpg', 'alt' => 'A', 'sort_order' => 1, 'is_active' => true]);
        Gallery::query()->create(['category' => 'Lingkungan', 'image' => 'galeri/b.jpg', 'alt' => 'B', 'sort_order' => 2, 'is_active' => true]);
        Gallery::query()->create(['category' => 'Acara', 'image' => 'galeri/c.jpg', 'alt' => 'C', 'sort_order' => 0, 'is_active' => false]);

        $gallery = Gallery::query()->activeOrdered()->get();

        $this->assertSame(['Kegiatan', 'Lingkungan'], $gallery->pluck('category')->all());
    }

    public function test_public_home_page_still_returns_success(): void
    {
        $this->get('/')->assertOk();
    }
}
