<?php

namespace Tests\Feature;

use App\Models\PerangkatDesa;
use App\Models\VillageSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VillageSettingTest extends TestCase
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

    public function test_village_setting_can_be_saved(): void
    {
        VillageSetting::factory()->create([
            'id' => 1,
            'name' => 'Desa Uji',
            'population' => 1234,
        ]);

        $setting = VillageSetting::query()->findOrFail(1);

        $this->assertSame('Desa Uji', $setting->name);
        $this->assertSame(1234, $setting->population);
    }

    public function test_only_active_officials_are_returned_in_sort_order(): void
    {
        PerangkatDesa::query()->create(['name' => 'B', 'position' => 'Jabatan B', 'image' => 'b.jpg', 'sort_order' => 2, 'is_active' => true]);
        PerangkatDesa::query()->create(['name' => 'A', 'position' => 'Jabatan A', 'image' => 'a.jpg', 'sort_order' => 1, 'is_active' => true]);
        PerangkatDesa::query()->create(['name' => 'Nonaktif', 'position' => 'Jabatan C', 'image' => 'c.jpg', 'sort_order' => 0, 'is_active' => false]);

        $names = PerangkatDesa::query()->activeOrdered()->pluck('name')->all();

        $this->assertSame(['A', 'B'], $names);
    }

    public function test_public_home_page_remains_available(): void
    {
        $this->get('/')->assertOk();
    }
}
