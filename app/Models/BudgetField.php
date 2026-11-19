<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetField extends Model
{
    protected $fillable = ['code', 'name'];

    protected function casts(): array
    {
        return ['code' => 'integer'];
    }

    public function activities(): HasMany
    {
        return $this->hasMany(BudgetActivity::class);
    }
}
