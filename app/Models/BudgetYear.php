<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetYear extends Model
{
    protected $fillable = ['year', 'is_active', 'report_pdf'];

    protected function casts(): array
    {
        return ['year' => 'integer', 'is_active' => 'boolean'];
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(BudgetIncome::class);
    }

    public function financing(): HasMany
    {
        return $this->hasMany(BudgetFinancing::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(BudgetActivity::class);
    }
}
