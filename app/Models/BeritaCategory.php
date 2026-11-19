<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeritaCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class);
    }
}
