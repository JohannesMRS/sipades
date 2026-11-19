<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['type', 'image', 'category', 'alt', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActiveOrdered(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    protected static function booted(): void
    {
        static::creating(function (Gallery $gallery): void {
            if (blank($gallery->type) && filled($gallery->category)) {
                $gallery->type = match (mb_strtolower($gallery->category)) {
                    'lingkungan' => 'lingkungan',
                    'acara' => 'acara',
                    default => 'kegiatan',
                };
            }
        });
    }
}
