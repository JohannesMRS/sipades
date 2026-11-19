<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\PotensiDesa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PotensiGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = config('village');

        foreach (array_values($village['potentials'] ?? []) as $index => $item) {
            PotensiDesa::query()->updateOrCreate(
                ['title' => $item['title']],
                [
                    'type' => Str::lower($item['category']),
                    'category' => $item['category'],
                    'description' => $item['text'] ?? '',
                    'image' => $item['image'] ?? null,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }

        foreach (array_values($village['gallery'] ?? []) as $index => $item) {
            Gallery::query()->updateOrCreate(
                ['alt' => $item['alt'], 'category' => $item['cat']],
                [
                    'category' => $item['cat'],
                    'image' => $item['src'] ?? null,
                    'alt' => $item['alt'] ?? '',
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }
}
