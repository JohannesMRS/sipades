<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use App\Models\VillageSetting;
use Illuminate\Database\Seeder;

class VillageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = config('village');

        VillageSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => $village['name'] ?? '—',
                'tagline' => $village['tagline'] ?? null,
                'logo' => $village['logo'] ?? null,
                'population' => 0,
                'family_count' => 0,
                'hamlet_count' => 0,
                'area_size' => 0,
                'area_unit' => 'km²',
                'address' => $village['contact']['address'] ?? null,
                'phone' => $village['contact']['phone'] ?? null,
                'email' => $village['contact']['email'] ?? null,
                'operational_hours' => $village['contact']['hours'] ?? null,
                'map_embed' => $village['contact']['map_embed'] ?? null,
            ],
        );

        foreach (array_values($village['officials'] ?? []) as $index => $official) {
            PerangkatDesa::query()->updateOrCreate(
                ['name' => $official['name'], 'position' => $official['role']],
                [
                    'image' => $official['photo'],
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }
}
