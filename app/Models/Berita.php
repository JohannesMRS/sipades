<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_category_id', 'title', 'slug', 'excerpt', 'content', 'image',
        'status', 'published_at', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BeritaCategory::class, 'berita_category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'terbit')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
