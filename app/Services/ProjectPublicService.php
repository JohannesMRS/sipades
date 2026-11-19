<?php

namespace App\Services;

use App\Models\Pembangunan;

class ProjectPublicService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function projects(): array
    {
        return Pembangunan::query()->with('documentation')->orderBy('start_date')->get()->map(function (Pembangunan $project): array {
            $image = $project->image
                ? (str_starts_with($project->image, 'http://') || str_starts_with($project->image, 'https://')
                    ? $project->image
                    : '/storage/'.ltrim($project->image, '/'))
                : '';

            return [
                'name' => $project->name,
                'loc' => $project->location,
                'cat' => $project->category,
                'budget' => (int) $project->budget,
                'start' => $project->start_date?->format('Y-m-d'),
                'end' => $project->end_date?->format('Y-m-d'),
                'status' => $project->status,
                'progress' => (int) $project->progress,
                'source' => $project->source,
                'exec' => $project->executor,
                'image' => $image,
                'desc' => $project->description,
                'docs' => $project->documentation->map(fn ($doc): array => [
                    'stage' => $doc->stage,
                    'date' => $doc->date?->format('Y-m-d'),
                    'caption' => $doc->caption,
                    'img' => str_starts_with($doc->image, 'http://') || str_starts_with($doc->image, 'https://')
                        ? $doc->image
                        : '/storage/'.ltrim($doc->image, '/'),
                ])->values()->all(),
            ];
        })->all();
    }
}
