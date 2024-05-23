<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashPaymentItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function budgethead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

}
