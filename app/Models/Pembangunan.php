<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembangunan extends Model
{
    protected $fillable = ['name', 'location', 'category', 'budget', 'start_date', 'end_date', 'status', 'progress', 'source', 'executor', 'image', 'description'];

    protected function casts(): array
    {
        return [
            'budget' => 'integer',
            'progress' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function documentation(): HasMany
    {
        return $this->hasMany(ProjectDocumentation::class, 'pembangunan_id');
    }

    protected static function booted(): void
    {
        static::saving(function (Pembangunan $project): void {
            if ($project->status === 'Selesai') {
                $project->progress = 100;
            } elseif ($project->status === 'Akan Dilaksanakan') {
                $project->progress = 0;
            }
        });
    }
}
