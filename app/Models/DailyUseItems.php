<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyUseItems extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function budgetHead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

    public function uses(): HasOne
    {
        return $this->hasOne(DailyUses::class, 'id', 'daily_consumption_id');
    }


}
