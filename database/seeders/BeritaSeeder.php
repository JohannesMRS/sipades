<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\BeritaCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = config('village.news', []);

        foreach ($news as $index => $item) {
            $categoryName = $item['category'] ?? 'Berita';
            $category = BeritaCategory::query()->firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName],
            );

            $title = $item['title'];
            $slug = Str::slug($title);

            Berita::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'berita_category_id' => $category->id,
                    'title' => $title,
                    'excerpt' => $item['excerpt'] ?? '',
                    'content' => isset($item['content']) ? implode("\n", array_map(fn (string $paragraph): string => '<p>'.e($paragraph).'</p>', $item['content'])) : null,
                    'image' => $item['image'] ?? null,
                    'status' => 'terbit',
                    'published_at' => now()->subMinutes(count($news) - $index),
                    'is_featured' => $index === 0,
                ],
            );
        }
    }
}
