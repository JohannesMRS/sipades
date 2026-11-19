<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocumentation extends Model
{
    protected $fillable = ['pembangunan_id', 'stage', 'date', 'caption', 'image'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Pembangunan::class, 'pembangunan_id');
    }
}
