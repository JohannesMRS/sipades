<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = ['title', 'category', 'year', 'file', 'description', 'is_published', 'download_count'];

    protected function casts(): array
    {
        return ['year' => 'integer', 'is_published' => 'boolean', 'download_count' => 'integer'];
    }
}
