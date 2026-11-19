<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(AdminSeeder::class);
        $this->call(VillageSettingSeeder::class);
        $this->call(BeritaSeeder::class);
        $this->call(PotensiGallerySeeder::class);
        $this->call(ApbdesSeeder::class);
        $this->call(PembangunanDokumenSeeder::class);
    }
}
