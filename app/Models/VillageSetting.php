<?php

namespace App\Models;

use Database\Factories\VillageSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    /** @use HasFactory<VillageSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'tagline', 'logo', 'population', 'family_count', 'hamlet_count',
        'area_size', 'area_unit', 'address', 'phone', 'email', 'operational_hours', 'map_embed',
        'deskripsi_singkat', 'foto_profil', 'sejarah', 'visi', 'misi', 'letak_geografis',
        'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat',
    ];

    protected function casts(): array
    {
        return [
            'population' => 'integer',
            'family_count' => 'integer',
            'hamlet_count' => 'integer',
            'area_size' => 'decimal:2',
            'misi' => 'array',
        ];
    }
}
