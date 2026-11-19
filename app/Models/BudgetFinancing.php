<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetFinancing extends Model
{
    protected $table = 'budget_financing';

    protected $fillable = ['budget_year_id', 'type', 'name', 'budget_amount', 'realized_amount'];

    protected function casts(): array
    {
        return ['budget_amount' => 'integer', 'realized_amount' => 'integer'];
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(BudgetYear::class, 'budget_year_id');
    }

    protected static function booted(): void
    {
        static::saving(function (BudgetFinancing $financing): void {
            if ($financing->realized_amount > $financing->budget_amount) {
                throw new \InvalidArgumentException('Realisasi pembiayaan tidak boleh melebihi anggaran.');
            }
        });
    }
}
