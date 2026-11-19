<?php

namespace Database\Seeders;

use App\Models\Pembangunan;
use App\Models\ProjectDocumentation;
use Illuminate\Database\Seeder;

class PembangunanDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('sipades.projects', []) as $project) {
            $model = Pembangunan::query()->updateOrCreate(
                ['name' => $project['name']],
                [
                    'location' => $project['loc'] ?? '—',
                    'category' => $project['cat'] ?? '—',
                    'budget' => $project['budget'] ?? 0,
                    'start_date' => $project['start'] ?? null,
                    'end_date' => $project['end'] ?? null,
                    'status' => $project['status'] ?? 'Akan Dilaksanakan',
                    'progress' => $project['progress'] ?? 0,
                    'source' => $project['source'] ?? null,
                    'executor' => $project['exec'] ?? null,
                    'image' => $project['image'] ?? null,
                    'description' => $project['desc'] ?? null,
                ],
            );

            foreach ($project['docs'] ?? [] as $doc) {
                ProjectDocumentation::query()->updateOrCreate([
                    'pembangunan_id' => $model->id,
                    'stage' => $doc['stage'],
                    'date' => $doc['date'],
                    'caption' => $doc['caption'],
                ], ['image' => $doc['img'] ?? null]);
            }
        }
    }
}
