<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetIncome extends Model
{
    protected $fillable = ['budget_year_id', 'group', 'name', 'budget_amount', 'realized_amount'];

    protected function casts(): array
    {
        return ['budget_amount' => 'integer', 'realized_amount' => 'integer'];
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(BudgetYear::class, 'budget_year_id');
    }
}
