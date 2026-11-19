<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetActivity extends Model
{
    protected $fillable = ['budget_year_id', 'budget_field_id', 'name', 'budget_amount', 'realized_amount', 'status'];

    protected function casts(): array
    {
        return ['budget_amount' => 'integer', 'realized_amount' => 'integer'];
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(BudgetYear::class, 'budget_year_id');
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(BudgetField::class, 'budget_field_id');
    }

    protected static function booted(): void
    {
        static::saving(function (BudgetActivity $activity): void {
            if ($activity->realized_amount > $activity->budget_amount) {
                throw new \InvalidArgumentException('Realisasi kegiatan tidak boleh melebihi anggaran.');
            }
        });
    }
}
