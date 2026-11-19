<?php

namespace Database\Factories;

use App\Models\VillageSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VillageSetting>
 */
class VillageSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Desa Contoh',
            'tagline' => 'Tagline Contoh',
            'logo' => 'images/logo.png',
            'population' => 1000,
            'family_count' => 250,
            'hamlet_count' => 4,
            'area_size' => 12.5,
            'area_unit' => 'km²',
            'address' => 'Alamat Contoh',
            'phone' => '-',
            'email' => '-',
            'operational_hours' => '-',
        ];
    }
}
